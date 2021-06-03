<template>
    <div class="text-center">
        <scale-loader :loading="loading" :color="color" :size="size"></scale-loader>
    </div>
</template>

<script>
import ScaleLoader from 'vue-spinner/src/ScaleLoader.vue';
export default {
    name: "loading",
    props:['loading'],
    data(){
      return{
          color: "#5dc596",
          size: "15px",
      }
    },
    components:{
        ScaleLoader,
    }
}
</script>

<style scoped>

</style>
