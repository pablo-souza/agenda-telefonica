<template>
    <div class="details">
      <div class="card" style="width: 100%;">
        <div class="card-body">
          <div>
            <div>
              <h1 class="card-title">
                <span>{{contact.name}}</span>
                <span class="edit-nome">
                  <b-button size="sm" class="mb-3" 
                      style="color:transparent;border:none;background:transparent"
                      v-b-modal.modal-xl>
                    <b-icon-pencil-fill variant="warning"></b-icon-pencil-fill>
                  </b-button>
                </span>
              </h1> 
            </div>
             
          </div>
            <Phones :phone="phone" v-for="(phone,index) in contact.phones" 
            :key="index" 
            v-on:remove="remove(phone.id,contact)"
            v-on:edit="editPhoneNumber(index)"></Phones>
            <b-row class="text-center">
              <b-col cols="12">
                <b-button size="lg" class="mb-3" 
                style="color:transparent;border:none;background:transparent"
                v-b-modal.modal-add-new-phone>
                  <b-icon-plus-circle-fill variant="success"/>
                </b-button>
                </b-col>
            </b-row>
        </div>
      </div>
      <div class="card" style="width: 100%;">
          <div class="card-body">
            <Adresses :address="contact.address" v-on:editAddress="editAddress"/>
            <b-row v-if="contact.id===-1" align-h="end" style="margin-top:10px">
              <b-col cols="12" align-self="end"  class="modal-footer">
                <b-button variant="danger"  @click="removeContact()">Cancelar</b-button>
                <b-button variant="success" @click="save">Salvar</b-button>
              </b-col>
            </b-row> 
          </div>
      </div>
      <b-modal 
      id="modal-add-new-phone" 
      title="Adicionar número:" 
      cancel-title="Cancelar"
      ref="modal"
      @show="resetModal"
      @hidden="resetModal"
      @ok="handleOk">
        <form ref="form" @submit.stop.prevent="handleSubmit">
            <b-form-group
            label="*Número:"
            label-for="name-input"
            invalid-feedback="Informe um número válido!"
            :state="phoneState"
            >
            <b-form-input
                id="name-input"
                v-model="newPhone"
                :state="phoneState"
                required
            ></b-form-input>
            </b-form-group>
        </form>
      </b-modal>
      <b-modal 
      id="modal-xl" 
      size="sm" 
      title="Nome:" 
      cancel-title="Cancelar"
      @ok="validityModalName"
      @show="newName=contact.name"
      >
        <input v-model="newName" placeholder="Digite o nome..." required>
      </b-modal>

      <b-alert
        :show="dismissCountDown"
        dismissible
        variant="danger"
        @dismissed="dismissCountDown=0"
        @dismiss-count-down="countDownChanged"
        class="alert-mensage"
      >{{mensage}}
      </b-alert>

      <b-modal
        id="modal-prevent-closing"
        ref="modal"
        title="Editar número"
        cancel-title="Cancelar"
        @hidden="resetModalPhone"
        @ok="handleOkPhone"
        >
        <form ref="form" @submit.stop.prevent="handleSubmit">
            <b-form-group
            label="*Número:"
            label-for="name-input"
            invalid-feedback="Informe um número válido!"
            :state="phoneState"
            >
            <b-form-input
                id="name-input"
                v-model="editPhone.number"
                :state="phoneState"
                required
            ></b-form-input>
            </b-form-group>
        </form>
      </b-modal>

    </div>
</template>

<script>
import Phones from './Phones.vue'
import Adresses from './Adresses.vue'
import axios from 'axios';
export default {
  name: 'Details',
  components: {
    Phones,
    Adresses
  },
  props: {
    contact:Object
  },
  data(){
    return{
      dismissSecs: 4,
      dismissCountDown: 0,
      showDismissibleAlert: false,
      mensage:null,
      newName:null,
      newPhone:'',
      editPhone:'',
      phoneState: null
    }
  },
  methods:{
    countDownChanged(dismissCountDown) {
        this.dismissCountDown = dismissCountDown
    },
    showAlert(mensage) {
      this.mensage = mensage;
      this.dismissCountDown = this.dismissSecs;
      this.showDismissibleAlert = true;
    },
    validityModalName(){
      if(this.newName!='' && this.newName!=null && this.newName.replace(/[0-9]/ig,"").length>0){
        this.contact.name = this.newName;
        this.$bvModal.hide('modal-xl');
      }
    },
    checkFormValidity() {
        let valid = true;
        if( valid && (this.newPhone.replace(/[^0-9]/g,"").length<10 || this.newPhone.replace(/[^0-9]/g,"").length>11)){
            valid = false;
            this.phoneState = valid;
        }
        return valid;
    },
    resetModal() {
        this.phoneState = null;
        this.newPhone = '';
    },
    handleOk(bvModalEvt) {
        bvModalEvt.preventDefault();
        this.handleSubmit();
    },
    handleSubmit() {
        if (!this.checkFormValidity()) {
        return
        }
        if(this.contact.id!=-1){
          axios.post('http://localhost:8000/contacts/'+this.contact.id+'/phone/'+this.newPhone)
          .then(response => {
            this.contact.phones.push({
              id:response.data,
              number:this.newPhone
            });
            this.newPhone = '';
          });
        }else{
          this.contact.phones.push({
            id:new Date().getTime(),
            number:this.newPhone
          });
        }
        this.$nextTick(() => {
        this.$bvModal.hide('modal-add-new-phone')
        })
    },
    editPhoneNumber(index){
      this.editPhone={
        id:this.contact.phones[index].id,
        number:this.contact.phones[index].number,
        index:index
      };
      this.editPhone.number=this.editPhone.number.replace(/^(\d\d)(\d{5})(\d{4}).*/,"($1) $2-$3");
      this.$bvModal.show('modal-prevent-closing');
    },
    resetModalPhone(){
      
    },
    checkFormValidityPhone() {
      let valid = true;
      if(this.editPhone.number.replace(/[^0-9]/g,"").length<10 || this.editPhone.number.replace(/[^0-9]/g,"").length>11){
          valid = false;
          this.phoneState = valid;
      }
      return valid;
    },
    handleOkPhone(bvModalEvt) {
        bvModalEvt.preventDefault();
        this.handleSubmitPhone();
    },
    handleSubmitPhone() {
        if (!this.checkFormValidityPhone()) {
        return
        }
        axios.put('http://localhost:8000/phone/'+this.editPhone.id+'/'+this.editPhone.number.replace(/[^0-9]/g,""))
        .then(response =>{
            if(response.status==200){
                console.log(response);
                this.contact.phones[this.editPhone.index].number=this.editPhone.number.replace(/[^0-9]/g,"");
                //console.log(this.editPhone.number);
                console.log(this.contact.phones[this.editPhone.index].number);
            }
        })
        this.$nextTick(() => {
        this.$bvModal.hide('modal-prevent-closing')
        })
    },
    save(){
      console.log(this.contact);
      if(this.contact.phones.length==0){
        this.showAlert('É preciso adionar ao menos um numero de telefone!');
        return false;
      }
      if(this.contact.address.street== null){
        this.showAlert('A rua não pode ser nula!');
        return false;
      }
      if(this.contact.address.number== null){
        this.showAlert('O numero não pode ser nulo!');
        return false;
      }
      if(this.contact.address.neighborhood== null){
        this.showAlert('O bairro não pode ser nulo!');
        return false;
      }
      if(this.contact.address.city== null){
        this.showAlert('A cidade não pode ser nula!');
        return false;
      }
      axios.post('http://localhost:8000/contacts/', JSON.stringify(this.contact), {
          headers: {
            'Content-Type': 'application/json'
          }
        }).then(response=>{
          console.log(response.data);
          this.contact.id = response.data.id;
          this.contact.address.id = response.data.address.id;
          this.contact.phones =  response.data.phones;
        });
    },
    remove(idPhone,contact){
      if(contact.phones.length==1){
        this.removeContact();
      }else{
        for(let i=0; i<contact.phones.length;i++){
          if(contact.phones[i].id==idPhone){
            axios.delete('http://localhost:8000/phone/'+contact.phones[i].id).then(response=>{
              if(response.status==200){
                contact.phones.splice(i, 1);
              }
            });
            break;
          }
        }
      }
    },
    removeContact(){
      this.$emit('remove',this.contact.id);
    },
    editAddress(address){
      if(this.contact.id == -1){
        this.contact.address={
          street:address.street,
          number:address.number,
          neighborhood:address.neighborhood,
          city:address.city
        }
      }
      if(this.contact.id!=-1){
          this.contact.address.street = address.street;
          this.contact.address.number = address.number; 
          this.contact.address.neighborhood = address.neighborhood;
          this.contact.address.city = address.city; 
          axios.put('http://localhost:8000/contacts/'+this.contact.id+'/', JSON.stringify(this.contact), {
          headers: {
            'Content-Type': 'application/json'
          }
        });
      }
    }
  }
}
</script>
<style scoped>
.card-title{
  text-align:center;
}
.edit-nome{
  position: absolute;
  top: 10px;
}
.alert-mensage{
  position: absolute;
  top: 30px;
  right: 30px;
}
.details{
  margin-top: 15px;
}
</style>