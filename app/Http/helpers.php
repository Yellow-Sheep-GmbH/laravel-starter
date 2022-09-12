<?php

use A17\Twill\Image\Models\Image;
use A17\Twill\Models\Block;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

if (!function_exists('transformMediasToImages')) {
    function transformMediasToImages(Model $entry, $withFullSizeUrl = false)
    {
        $images = [];
        foreach ($entry['medias'] as $media) {
            $crop = $media->pivot->crop ?? 'default';
            $role = $media->pivot->role ?? 'default';
            $image = (new Image($entry, $role, $media))->crop($crop)->toArray()['image'];
            if ($withFullSizeUrl) $image['url'] = config()->get("app.url") . Storage::url("uploads/$media->uuid");

            if ($images[$role][$crop] ?? false) {
                if ($images[$role][$crop]['src'] ?? false) {
                    $prevImage  = $images[$role][$crop];
                    $images[$role][$crop] = [];
                    $images[$role][$crop][] = $prevImage;
                    $images[$role][$crop][] = $image;
                } else {
                    $images[$role][$crop][] = $image;
                }
            } else {
                $images[$role][$crop] = $image;
            }
        };
        $entry->unsetRelation("medias");
        return array_merge(
            $entry->toArray(),
            compact('images'),
        );
    }
}

if (!function_exists('getActiveTranslationFromBlock')) {
    function getActiveTranslationFromBlock(Block $block)
    {
        $locale = LaravelLocalization::getCurrentLocale() ?? 'de';
        $block->content = collect($block->content)->mapWithKeys(function ($entry, $key) use ($locale) {
            if (is_array($entry) && array_key_exists($locale, $entry))
                return [$key => $entry[$locale]];
            $defaultLocale = LaravelLocalization::getDefaultLocale();
            if (is_array($entry) && array_key_exists($defaultLocale, $entry))
                return [$key => $entry[$defaultLocale]];
            if (is_array($entry))
                return [$key => null];
            return [$key => $entry];
        })->toArray();
        if ($block->children->isNotEmpty()) {
            $block->children = $block->children->map(function ($block) {
                return getActiveTranslationFromBlock($block);
            });
        }
        return $block;
    }
}

if (!function_exists('getBlocksFromEntry')) {
    function getBlocksFromEntry($entry)
    {
        $blocks = $entry->blocks;
        return $blocks->map(function ($block) {
            return transformMediasToImages(
                getActiveTranslationFromBlock(
                    getRelatedItemsOnBlock(
                        $block
                    )
                )
            );
        });
    }
}

if (!function_exists('getRelatedItemsOnBlock')) {
    function getRelatedItemsOnBlock($block)
    {
        $related = [];
        foreach ($block->relatedItems as $item) {
            $browser = $item['browser_name'];
            $relatedItem = transformMediasToImages($item->related);
            if ($related[$browser] ?? false) {
                if ($related[$browser]['id'] ?? false) {
                    $prev = $related[$browser];
                    $related[$browser] = [];
                    $related[$browser][] = $prev;
                    $related[$browser][] = $relatedItem;
                } else {
                    $related[$browser][] = $relatedItem;
                }
            } else {
                $related[$browser] = $relatedItem ?? "test";
            }
        }
        $block["related"] = $related;
        $block->unsetRelation("relatedItems");
        return $block;
    }
}

if (!function_exists('transformFileUrls')) {
    function transformFileUrls($entry)
    {
        foreach ($entry['files'] as $key => $file) {
            $entry['files'][$key]["url"] = Storage::url("uploads/$file->uuid");
        };
        return $entry;
    }
}
