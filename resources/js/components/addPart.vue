<template>
     <div class="row">
    <div class="col-6 col-md-4"></div>
      <div class="col-6 col-md-4" style="text-align: center;">
         <h1 style="font-size:1rem" >{{this.title}}</h1>         
         <label style="padding: .5rem;" for="name">Car name</label>
         <input class="form-control" v-model="this.name" id="name"  type="text" placeholder="name" aria-label="default input example">         
        <transition name="slide-fade">
            <div>
                <label for="staticEmail2">Serial number</label>
                <input class="form-control" type="number" v-model="this.serial" placeholder="serial" aria-label="default input example">          
            </div>    
        </transition>
        <div style="padding:1rem 0rem;" class="d-grid gap-2 d-md-flex justify-content-md-end">            
            <button v-if="edit === false" @click.prevent="addNewPart()" class="btn btn-success btn-sm  " type="button">Add new part</button>
            <button v-if="edit" @click.prevent="chengePart()" class="btn btn-success btn-sm  " type="button">Change</button>
        </div>
    </div>
    <div class="col-6 col-md-4"></div>
  </div>

   
</template>

<script>
import axios from 'axios'
export default {
       props:{
           edit:{
             type:Boolean,
             default:false,
           },
           ide:{
               type:Number,
               default:null,
           },
          
       },
    data () {       

        return {
          title:'Add part',  
          name:'',
          serial:null,
          car:'',
          carIde:null,

        }
    },
    mounted () {        
        if(this.edit === true){
          this.axiosDataPart()
        }else{
         this.axiosDataCar()
        }
       
    },
    methods: {
        axiosDataCar(){
              axios.get('cars/'+this.ide+'/edit').then(res=>{              
                  this.title = 'Add part car name: '+res.data.name
                 
              })
         },
         addNewPart(){
            axios.post('part',{car_id:this.ide,name:this.name,serial_number:this.serial}).then(res=>{
                 this.$emit('msg',{visible:true,text:'Add part'})
            }).catch(e=>{
                 this.$emit('msg',{visible:true,text:'try again'})
            })
         },
         axiosDataPart(){
             axios.get('part/'+this.ide).then(res=>{
                 this.name = res.data.name
                 this.serial = res.data.serial_number
                 this.carIde = res.data.car_id
                 this.title = 'Change part name: '+res.data.name                
             }).catch(e=>{
                 this.$emit('msg',{visible:true,text:'try again'})
             })
        },
         chengePart(data){
            axios.put('part/'+this.ide,{name:this.name,serial_number:this.serial,car_id:this.carIde}).then(res=>{
                 this.$emit('msg',{visible:true,text:'Change part'})
            }).catch(e=>{
                 this.$emit('msg',{visible:true,text:'try again'})
            })
        }
      
     }
}
</script>

<style lang="scss" scoped>

</style>