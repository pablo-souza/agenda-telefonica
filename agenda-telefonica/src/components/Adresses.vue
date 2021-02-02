<template>
    <div>
        <div>
            <b-list-group>
            <b-list-group-item>Rua: {{address.street}}</b-list-group-item>
            <b-list-group-item>Numero: {{address.number}}</b-list-group-item>
            <b-list-group-item>Bairro: {{address.neighborhood}}</b-list-group-item>
            <b-list-group-item>Cidade: {{address.city}}</b-list-group-item>
            </b-list-group>
        </div>
        <div class="edit-endereco">
            <b-button size="lg" class="mb-3" 
            style="color:transparent;border:none;background:transparent"
            v-b-modal.modal-address>
                <b-icon-pencil-fill variant="warning"></b-icon-pencil-fill>
            </b-button>
        </div>
        <b-modal 
        id="modal-address" 
        size="md" 
        title="Endereço:" 
        cancel-title="Cancelar"
        @show="resetModal"
        @hidden="resetModal"
        @ok="handleOk">
            <form ref="form" @submit.stop.prevent="handleSubmit">
                <b-row>
                    <b-col cols="12">
                        <b-form-group label="*Rua:" label-for="name-input" >
                            <b-form-input v-model="street" required ></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col cols="12">
                        <b-form-group label="*Número:" label-for="name-input">
                            <b-form-input v-model="number" required></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col cols="12">
                        <b-form-group label="*Bairro:" label-for="name-input">
                            <b-form-input v-model="neighborhood" required></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col cols="12">
                        <b-form-group label="*Cidade:" label-for="name-input" >
                            <b-form-input v-model="city" required></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>
            </form>
        </b-modal>
    </div>
</template>
<script>
export default {
    name: 'Adresses',
    props: {
        address: {
            type: Object,
            default: function () {
                return { 
                    street:'',
                    number:'',
                    neighborhood:'',
                    city:'' 
                }
            }
        }
    },
    data(){
        return{
            street:'',
            number:'',
            neighborhood:'',
            city:''
        }
    },
    methods:{
        checkFormValidity() {
            let valid = this.$refs.form.checkValidity();
            if( valid && 
            (this.street.replace(/[^0-9A-z]/g,"").length==0 || 
            this.number.replace(/[^0-9A-z]/g,"").length==0 ||
            this.neighborhood.replace(/[^0-9A-z]/g,"").length==0 ||
            this.city.replace(/[^0-9A-z]/g,"").length==0)){
                valid = false;
                this.phoneState = valid;
            }
            return valid;
        },
        resetModal() {
            this.street = this.address.street;
            this.number = this.address.number;
            this.neighborhood =  this.address.neighborhood;
            this.city = this.address.city
        },
        handleOk(bvModalEvt) {
            bvModalEvt.preventDefault();
            this.handleSubmit();
        },
        handleSubmit() {
            if (!this.checkFormValidity()) {
                return
            }
            this.$emit('editAddress',{
                street:this.street,
                number:this.number,
                neighborhood:this.neighborhood,
                city:this.city
            });
            this.$nextTick(() => {
                this.$bvModal.hide('modal-address')
            });
        }
    }
}
</script>
<style scoped>
.edit-endereco{
  position: absolute;
  top: 0;
  right: -7px;
}
</style>