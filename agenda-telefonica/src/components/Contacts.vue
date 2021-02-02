<template>
  <div class="contact row">
    <div class="col-2 align-middle"><div class="prefexi ">{{prefexi()}}</div></div>
    <div class="name col-8 align-middle">{{contact.name}}</div>
  </div>
</template>

<script>
export default {
  name: 'Contacts',
  props: {
    contact: Object
  },
  methods:{
    prefexi(){
      let names = this.contact.name.split(" ");
      if (names.length>1){
        return (names[0].substr(0,1)+names[names.length-1].substr(0,1)).toUpperCase();
      }else{
        return names[0].substr(0,1).toUpperCase();
      }
    }
  }
}
</script>

<style scoped>
.contact {
  margin: 0px;
  border-bottom: 1px solid #ccc;
  padding: 8px;
  cursor: pointer;
}
.prefexi {
  background-color: #B1D4E0;
  height: 1.8em;
  width: 1.8em;
  border-radius: 100%;
}
.prefexi {
  font-size: 1em;
  text-align: center;
  line-height: 1.8em;
  color:#2E8BC0;
}
.name{
  color:#2E8BC0;
  word-wrap: break-word;
  font-size: 1em;
}
</style>
