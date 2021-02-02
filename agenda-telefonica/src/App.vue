<template>
  <div id="app">
    <b-container fluid class="bv-example-row">
      <b-row>
        <b-col cols="3" style="background: linear-gradient(-33deg, #145DA0 0%, #0C2D48 100%);">
          <div class="left-bar">
            <input type="text" class="search" placeholder="Digite..." v-model="search">
            <Contacts 
                  v-for="contact in resultQuery" 
                  :key="contact.id" 
                  :contact="contact"
                  @click.native="selectContact(contact)"
                  />
            <b-row class="text-center">
              <b-col cols="12">
                <b-button size="lg" class="mb-3" 
                style="color:transparent;border:none;background:transparent"
                @click="addNewContact()">
                  <b-icon-plus-circle-fill class="add"/>
                </b-button>
              </b-col>
            </b-row>
          </div>
        </b-col>
        <b-col cols="9" style="background:#e2e2e2">
          <div v-if="contactSelected!=null">
            <Details :contact="contactSelected" v-on:remove="removeAlert"></Details>
          </div>
          <div v-else >
            <div class="view-default"><b-icon-telephone-plus class="view-default-icon"></b-icon-telephone-plus></div>
          </div>
        </b-col>
      </b-row>  
    </b-container> 
    <b-alert class="alert-mensage" v-model="showDismissibleAlert" variant="danger" dismissible>
      Você possui um contato que não foi salvo!
    </b-alert>
    <b-modal
    id="modal-danger"
    header-bg-variant="danger"
    header-text-variant="light"
    ok-variant="danger"
    cancel-variant="success"
    cancel-title="Cancelar"
    title="Excluir contato"
    @ok="remove"
    @hidden="resetModal">
        <p class="my-4">Deseja excluir realmente esse contato?</p>
    </b-modal>
  </div>
</template>

<script>
import Contacts from './components/Contacts.vue'
import Details from './components/Details.vue'
import axios from 'axios';
export default {
  name: 'App',
  components: {
    Contacts,
    Details
  },
  data(){
    return{
      search:null,
      contactSelected:null,
      showDismissibleAlert: false,
      removeContact:null,
      contacts:[],
      baseUrl : window.location.protocol + "//" + window.location.host
    }
  },
  computed: {
    resultQuery(){
      if(this.search){
      return this.contacts.filter((item)=>{
        return this.search.toLowerCase().split(' ').every(v => item.name.toLowerCase().includes(v));
      })
      }else{
        return this.contacts;
      }
    }
  },
  methods:{
    selectContact(contact){
      this.contactSelected = contact; 
      console.log( JSON.stringify(contact));
    },
    addNewContact() {
      let contactNotAdd = this.contacts.filter((contact)=>{
        if (contact.id === -1){
          return contact;
        }
      });
      if (contactNotAdd.length==0){
        this.contacts.push({
          id:-1,
          name:"Novo Contato",
          phones:[],
          address:{}
        });
        this.contactSelected=this.contacts[this.contacts.length-1];
      }else{
        this.showDismissibleAlert=true;
      }
    },
    resetModal(){
      this.removeContact = null
    },
    removeAlert(id){
      this.removeContact = id;
      this.$bvModal.show('modal-danger');
    },
    remove(){
      for(let i =0;i<this.contacts.length;i++){
        if(this.contacts[i].id == this.removeContact){
          axios.delete('http://localhost:8000/contacts/'+this.contacts[i].id).then(
            response=>{
              if(response.status==200){
                this.contacts.splice(i, 1);
              }
            }
          );
          break;
        }
      }
      this.contactSelected=null;
      this.resetModal();
    }
  },
  mounted:function(){
        fetch('http://localhost:8000/contacts/')
          .then(response => response.json())
          .then(response => 
              this.contacts = response
          );
  }
}
</script>

<style scoped>
.card-main{
  position: relative;
  top:15px;
}
.left-bar{
  width: 100%;
  height: 100vh;
}
.search{
  background: #3f668866;
  color: #fff;
  border: none;
  width: 100%;
  border-radius: 4px;
  margin-top: 8px;
  padding: 4px;
}
.add{
  color: #B1D4E0;
  height: 3vw;
  width: 3vw;
  border-radius: 100%;
}
.alert-mensage{
  position: absolute;
  top: 30px;
  right: 30px;
}
.view-default{
  width: 100%;
  height: auto;
  text-align: center;
  padding-top: 3em;
}
.view-default-icon{
  font-size: 80vh;
  color: #f5f5f5;
}
</style>
