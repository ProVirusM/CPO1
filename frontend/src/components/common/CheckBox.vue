<script setup>
    import { watch } from 'vue';
    const props = defineProps({
        title: String,
        disabled: Boolean,
        checked: {
            type: Boolean,
            default: false
        },
        behavior:{
            type: String,
            validator: value => ['manualy','default'].includes(value),
            default: 'default'
        },
    })
    const model = defineModel()
    const emits = defineEmits(['changed'])

    watch(()=>props.checked, ()=>{
        updateChecked()
    })

    function updateChecked(){
        if(props.checked)
            model.value = true
        else
            model.value = false
    }
    updateChecked()

    function unCheck(){
        model.value = false
    }

    function check(){
        model.value = true
    }

    function clickedLabel(){
        if(props.behavior == 'manual'){
            manualCheck()
            return
        }
        model.value = !model.value
        emits('changed',model.value)
        
    }

    function clickedBox(){
        if(props.behavior == 'manual'){
            manualCheck()
            return
        }
        emits('changed',model)
    }

    function manualCheck(){
        
        emits('changed',model)
        updateChecked()     
    }
    defineExpose(({unCheck,check}))
</script>

<template>
    <div>
        <div class="checkbox-wrapper-13 items-center flex gap-2 z-50">
            <input :disabled="props.disabled" @change="clickedBox" v-model="model" id="c1-13" type="checkbox">
            <label  :disabled="props.disabled" @click="clickedLabel" for="">{{props.title}}</label>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    @supports (-webkit-appearance: none) or (-moz-appearance: none) {
      .checkbox-wrapper-13 input[type=checkbox] {
        --active: #00DB62;
        --active-inner: #00DB62;
        --focus: 3px  #00C257;
        --border: #00C257;
        --border-hover: #00C257;
        --background: #fff;
        --disabled: #F6F8FF;
        --disabled-inner: #E1E6F9;
        -webkit-appearance: none;
        -moz-appearance: none;
        height: 21px;
        outline: none;
        display: inline-block;
        vertical-align: top;
        position: relative;
        margin: 0;
        cursor: pointer;
        border: 3px solid var(--bc, var(--border));
        background: var(--b, var(--background));
        transition: background 0.3s, border-color 0.3s, box-shadow 0.2s;
      }
      .checkbox-wrapper-13 input[type=checkbox]:after {
        content: "";
        display: block;
        left: 0;
        top: 0;
        position: absolute;
        transition: transform var(--d-t, 0.3s) var(--d-t-e, ease), opacity var(--d-o, 0.2s);
      }
      .checkbox-wrapper-13 input[type=checkbox]:checked {
        --b: var(--active);
        --bc: var(--active);
        --d-o: .3s;
        --d-t: .6s;
        --d-t-e: cubic-bezier(.2, .85, .32, 1.2);
      }
      .checkbox-wrapper-13 input[type=checkbox]:disabled {
        --b: var(--disabled);
        cursor: not-allowed;
        opacity: 0.9;
      }
      .checkbox-wrapper-13 input[type=checkbox]:disabled:checked {
        --b: var(--disabled-inner);
        --bc: var(--border);
      }
      .checkbox-wrapper-13 input[type=checkbox]:disabled + label {
        cursor: not-allowed;
      }
      .checkbox-wrapper-13 input[type=checkbox]:hover:not(:checked):not(:disabled) {
        --bc: var(--border-hover);
      }
      
      .checkbox-wrapper-13 input[type=checkbox]:not(.switch) {
        width: 21px;
      }
      .checkbox-wrapper-13 input[type=checkbox]:not(.switch):after {
        opacity: var(--o, 0);
      }
      .checkbox-wrapper-13 input[type=checkbox]:not(.switch):checked {
        --o: 1;
      }
      .checkbox-wrapper-13 input[type=checkbox] + label {
        display: inline-block;
        vertical-align: middle;
        cursor: pointer;
        margin-left: 4px;
      }
  
      .checkbox-wrapper-13 input[type=checkbox]:not(.switch) {
        border-radius: 7px;
      }
      .checkbox-wrapper-13 input[type=checkbox]:not(.switch):after {
        width: 5px;
        height: 9px;
        border: 2px solid var(--active-inner);
        border-top: 0;
        border-left: 0;
        left: 7px;
        top: 4px;
        transform: rotate(var(--r, 20deg));
      }
      .checkbox-wrapper-13 input[type=checkbox]:not(.switch):checked {
        --r: 43deg;
      }
    }
  
    .checkbox-wrapper-13 * {
      box-sizing: inherit;
    }
    .checkbox-wrapper-13 *:before,
    .checkbox-wrapper-13 *:after {
      box-sizing: inherit;
    }

</style>