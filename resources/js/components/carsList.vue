
<template>

   
    <div class="cars-list">
       <h1 style="text-align: center; padding: 0rem 0rem 1rem;">{{title}}</h1>
              <table class="table  table-hover" >
                    <thead>
                        <tr>
                        <th scope="col">Cars table</th>
                        <th scope="col">Name</th>
                        <th scope="col">Register number</th>
                        <th scope="col">Is registered</th>
                        <th scope="col">Part</th>
                        <th scope="col">Last edit</th>
                        </tr>       

                     </thead>
                    <tbody>
                    
                      <tr v-for="item in this.carsData" :key="item.id">
                         <th scope="row">{{item.id}}</th>
                         <td>{{item.name}}</td>
                         <td>{{item.registration_number === 0 ? item.registration_number = 'nop' : item.registration_number }}</td>
                          <td>
                               <svg v-if="item.is_registered === 1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>                            
                          </td>
                          <td>
                              <select style="padding:0.2rem" v-model="selected" class="form-select" aria-label="Disabled select example" >                                  
                                   <option v-for="part in item.part" :key="part.id"  :class="item.serial_number" v-bind:value="part.id">{{part.name}}&nbsp;</option>                                  
                              </select>                                         
                          </td>
                             <td><small>{{formatDate(item.updated_at)}}</small></td>      
                             <td style="text-align: center;"><button @click="editCars(item.id)" style="margin-left: .3rem; padding: 0.1rem 0.3rem;" type="button" class="btn btn-success btn-sm">Edit car</button></td>  
                             <td style="text-align: center;"><button @click="addPart(item.id)" style="margin-left: .3rem; padding: 0.1rem 0.3rem;" type="button" class="btn btn-success btn-sm">Add part</button></td>  
                             <td style="text-align: center;"><button @click="showPart(item.id)" style="margin-left: .3rem; padding: 0.1rem 0.3rem;" type="button" class="btn btn-success btn-sm">Show part</button></td>                
                             <td style="text-align: center;"><button @click="deleteCars(item.id)" style="font-size:.7rem; margin-left: .3rem; padding: 0.1rem 0.3rem;" type="button" class="btn btn-btn btn-danger btn-sm">Delete car</button></td>                                                                                                                     
                         </tr>                           
                    </tbody>                                  
                </table>                    
          </div>


</template>

<script>
import dayjs from 'dayjs';
import axios from 'axios'
export default {
    emits:['part-data','edit-cars','msg','idCar'],
    props:{
        dataCars:{
            type:Object,
            default:'nopArray'
        },
        searchData:{
            type:Array,
            default:[]
        }
    },
    data () {    

        return {
           partId:null,
           carsData:this.dataCars,

           partData:[],

           tableContend:false,

           serialNumber:4564,


           serial:'',
           
           selected:null,

           title:'Car list'     
           
           
          
        }

    },watch:{
        searchData:function(val){
            if(val.length > 0){
                this.carsData = val                            
            }
            if(val.length == 0){
               this.dataCreate()
            }
        }
    },
     mounted(){          
          this.dataCreate()
 
    },
    methods:{
      dataCreate(){
          axios.get('cars').then(res=>{
              this.carsData = res.data;
               this.carsData.forEach(function(item){
                 item.created_at = {edit:true}            
              })       
          }).catch(e=>{
              this.$emit('msg',{visible:true,text:'try again'})
          })       
          
                                          
      },
      formatDate(dateString) {
                    const data = dayjs(dateString);                      
                    return data.format('DD.MM.YYYY HH:mm:ss');
                   
         },   
      showPart(data){
           this.carsData.filter(item=>{
               if(item.id == data){this.partData = item.part}             
           })          
           
           this.$emit('part-data',{part:this.partData,selected:this.selected})          
            
       },
       editCars(data){
         this.$emit('edit-cars',data)
        
       },   
       deleteCars(data){          
           if(confirm('definitely delete')){
                 axios.delete('cars/'+data).then(res=>{
                    this.$emit('msg',{visible:true,text:'Deleted'})
                    this.dataCars.filter(item=>{
                        if(item.id === data){
                            this.dataCars.splice(item.index,1)
                        }
                    })                   
                   
                 }).catch(e=>{
                    this.$emit('msg',{visible:true,text:'Nop deleted'})
                 })
           }else{
               return;
           }
         
       },addPart(data){
           this.$emit('idCar',data)
       }
        
    },
}
</script>

<style lang="scss" scoped>

 

</style>