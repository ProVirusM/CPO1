<script setup>
    import {onClickOutside} from '@vueuse/core'
    import {ref} from 'vue'

    const props = defineProps({
        title: String,
    })

    const opened = defineModel()

    const window = ref()
    onClickOutside(window,event=>{opened.value = false})
</script>

<template>
    <div @keyup.escape="opened = false" v-if="opened" class="modal-window">
        <div class="modal-window__dim">
            
        </div>
        <div ref="window" class="modal-window__window">
            <div class="modal-window__top-panel">
                <div class="title">
                    {{ props.title }}
                </div>
                <div class="cursor-pointer" @click="opened = false">
                    x
                </div>
            </div>
            <div class="modal-window__content">
                <slot></slot>
            </div>
            
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .modal-window{
        $borderRadius: 10px;
        //background-color: var(--primary-container-color);
        width: 100%;
        height: 100%;
        
        top:0;
        left:0;
        position: fixed;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        display: flex;
        
        &__dim{
            width:100%;
            height:100%;
            position: absolute;
            background-color: black;
            opacity: 0.4;
        }

        &__window{
            background-color: #EBEBEB;
            max-width: 100%;
            max-height: 100%;
            width: auto;
            position:sticky;
            top: 50%;
            margin-left: auto;
            margin-right: auto;
            left: 50%;
            display: flex;
            flex-direction: column;
            min-width: 200px;
            border-radius: $borderRadius;
            overflow: auto;
            z-index: 1002;
        }

        &__top-panel{
            height: 40px;
            width: 100%;
            background-color: #EBEBEB;
            display: flex;
            flex-direction: row;
            align-items: center;
            border-top-left-radius: $borderRadius;
            border-top-right-radius: $borderRadius;
            padding-left: 20px;
            padding-right: 10px;
            justify-content: space-between;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
        }

        &__content{
            padding: 20px;
        }

        .title{
            font-size: small;
        }
    }
</style>
