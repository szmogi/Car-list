<template>

  <div class="row">
    <div class="col-6 col-md-4"></div>
      <div class="col-6 col-md-4" style="text-align: center;">
         <h1>{{this.title}}</h1>
         <label style="padding: .5rem;" for="name">Car name</label>
           <input class="form-control" v-model="this.name" id="name"  type="text" placeholder="name" aria-label="default input example">    
       <div style="padding: 1rem 0 .5rem; display: flex; justify-content: flex-end;" class="form-check">
             <input v-if="ifRegistered === false" @click="this.registeredIf()" class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
             <svg v-if="ifRegistered" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
             </svg>
             <label style="margin-left: 1rem;" class="form-check-label" for="flexCheckChecked">
                  Register
            </label>
       </div>   
        <transition name="slide-fade">
            <div v-show="ifRegistered" >
                <label for="staticEmail2">Reg. number</label>
                <input class="form-control" type="number" v-model="this.regNumber" placeholder="reg. number" aria-label="default input example">
                <button @click="generateNumber()" style="margin:.5rem" type="button" class="btn btn-primary btn-sm">generate number</button>      
            </div>    
        </transition>

        <div style="padding:1rem 0rem;" class="d-grid gap-2 d-md-flex justify-content-md-end">            
            <button v-if="edit === false" @click="sendData()" class="btn btn-success btn-sm  " type="button">Add new car</button>
            <button v-if="edit" @click="chengeCar(this.editId)" class="btn btn-success btn-sm  " type="button">Change</button>
        </div>
    </div>
    <div class="col-6 col-md-4"></div>
  </div>

   
</template>

<script>
import axios from 'axios'
export default {
    emits:['new','msg'],
    props:{
      edit:{
         type:Boolean,
         default:false, 
      },
      editId:{
        type:Number,
        default:null
      }
    },


    data () {
        

        return {
            ifRegistered:false,
            regNumber:0,
            name:'',
            registered:0,   
            title:'Add new car',      
                       

        }
    },
    mounted(){
      this.ifEdit()
    },
    methods: {
        registeredIf(){
            if(event.target.checked === true){
                this.ifRegistered = true
                this.registered = 1
            }else{
               this.ifRegistered = false
               this.registered = 0
               
              }
        },
        sendData(){
            if(this.name.length > 0){
               axios.post('cars',{name:this.name,registrationNumber:this.regNumber,register:this.registered})
                  .then(res=>{
                    this.$emit('msg',{visible:true,text:'Added'})
                    this.$emit('new',{name:this.name,registrationNumber:this.regNumber,register:this.registered})
                    this.ifRegistered=false,
                    this.regNumber = 0,
                    this.name='',
                    this.registered=0
                     
                  }).catch(res=>{
                    this.$emit('msg',{visible:true,text:'try again'})
                  })
            }else{
               console.log('nop name')
          }
        },
        generateNumber(){
            this.regNumber = Math.floor(Math.random() * (10000 - 3000)+ 1000 );
        },        
        ifEdit(data){
           if(this.edit === true){
              this.title = 'Edit car'
              axios.get('cars/'+this.editId).then(res=>{   
                    this.name = res.data.name              
                   if(res.data.is_registered == 1){
                     this.ifRegistered = true 
                     this.regNumber = res.data.registration_number      
                   
                   }
              }).catch(e=>{
                this.$emit('msg',{visible:true,text:'try again'})
              })              
           }
        },
        chengeCar(data){          
          this.ifRegistered ? this.registered = 1 : this.registered = 0
          axios.put('cars/'+data,{name:this.name,register:this.registered,registrationNumber:this.regNumber})
          .then(res=>{
                    this.ifRegistered=false,
                    this.regNumber = 0,
                    this.name='',
                    this.registered=0,  
             
              this.$emit('msg',{visible:true,text:'Change OK'})
          }).catch(e=>{
            this.$emit('msg',{visible:true,text:'try again'})
          })
        },

    }
}
</script>

<style lang="scss" scoped>



.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}
</style>