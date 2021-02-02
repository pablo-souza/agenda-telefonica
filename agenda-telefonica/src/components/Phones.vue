<template>
    <div class="phone row">
        <b-col cols="10">
            <h5 class="number">
                <b-icon-telephone-forward-fill variant="success">
                </b-icon-telephone-forward-fill>
                {{format()}}
            </h5>
        </b-col>
        <b-col cols="1">
            <b-icon-pencil-fill variant="warning" @click="edit" class="icon"></b-icon-pencil-fill>
        </b-col>
        <b-col cols="1">
            <b-icon-trash-fill variant="danger" @click="remove" class="icon"></b-icon-trash-fill>
        </b-col>
        

    </div>
</template>
<script>
export default {
    name:'Phones',
    props: {
        phone: Object
    },
    methods:{
        format(){
            return this.phone.number.replace(/^(\d\d)(\d{5})(\d{4}).*/,"($1) $2-$3");
        },
        remove(){
            this.$emit('remove');
        },
        edit(){
            this.$emit('edit');
        }
    }
}
</script>
<style scoped>
.phone{
    padding: 8px;
    border-bottom: 1px solid #ccc;
}
.icon{
    cursor:pointer;
}
</style>