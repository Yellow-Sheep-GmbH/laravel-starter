<template>
    <picture v-bind="{
        width: image.width,
        height: image.height,
    }" class="block">
        <source :data-src="image.srcWebp" :data-srcset="image.srcSetWebp" type="image/webp">
        <source :data-srcset="image.srcSet">
        <img v-bind="{
            src: image.lqipBase64,
            'data-src': image.src,
            'data-sizes': 'auto',
            width: image.width,
            height: image.height,
            alt: image.alt
        }" class="bg-black lazyload object-cover object-center w-full h-full" :title="image.caption" />
    </picture>
</template>

<script setup lang="ts">
import "lazysizes"
interface Image {
    lqipBase64: string;
    width: number;
    height: number;
    srcSet: string;
    srcWebp: string;
    srcSetWebp: string;
    src: string;
    alt: string;
    caption: string;
}
defineProps<{
    image: Image,
}>()
</script>
