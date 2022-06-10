
<template>
        <transition name="slide-fade">    
            <div style="position: fixed;
                        right: 0rem;
                        background: #198754;
                        padding: 0.5rem 2rem;
                        color: rgb(248 255 255);
                        border-bottom-left-radius: 1pc;
                        border-top-left-radius: 1pc;" v-if="message" class="message">
                <h3 style="margin:0rem; font-size: 1.5rem;">{{textMsg}}</h3>             
            </div>
        </transition>
         
        <div class='container-xl' >
             <div style="text-align: center; font-size:1.5rem; padding:2rem; font-weight: bold;">
                 <h1>
                    Cars and their components
                </h1>
             </div>    
           <div class="list-cars">                
                <div style="display: inline;" class="container">
                    <div class="row">
                        <div class="col-4">                
                        </div>
                        <div class="col-4">
                                 <button v-if="this.searchItem.length > 0 " @click="this.searchItem = ''" style="font-size:.7rem; margin-left:.5rem; margin-bottom: .5rem;" type="button" class="btn btn-primary">Back</button>
                                 <div class="input-group">                                     
                                    <input type="text" class="form-control" v-model="searchItem" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
                                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>                                    
                                </div>          
                                                   
                        </div>
                        <div style="text-align: end;" class="col-4">
                            <button v-if="back" @click="visible(0)" style="font-size:.7rem; margin-left:.5rem;" type="button" class="btn btn-primary">Back</button>
                            <button style="margin-left:.5rem;" @click="this.visible(1)" type="button" class="btn btn-success">New Car</button>         
                                           
                        </div>
                    </div>               
                    </div>                   
                </div>  


     

                <div class="content">       

                       <transition name="slide-delet">
                              <div style="display: flex;
                                        flex-direction: row;
                                        justify-content: space-around; padding:5rem" v-if="iconDel"  class="icons">
                                   <svg  xmlns="http://www.w3.org/2000/svg" width="200" height="200" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                   </svg>
                               </div>
                       </transition>



                        <transition>                               
                            

                                    <list-cars v-if="this.navList[0].visible" 
                                    :dataCars="this.dataCars"
                                    @partData="this.dataPart($event)"
                                    @editCars="this.editCar($event)" 
                                    @msg="this.messages($event)"
                                    @idCar="this.partAdd($event)"
                                    :searchData="this.searchData"
                                    >

                                    </list-cars>
                                


                                    <new-cars-part
                                    v-else-if="this.navList[1].visible"
                                    :editId="editIdCar"
                                    :edit="ifEditCar"
                                    @msg="this.messages($event)"
                                    @new="this.appedNewData($event)">

                                    </new-cars-part>

                                    <part-list
                                        v-else-if="this.navList[2].visible"
                                        :part-data="this.partData"
                                        @msg="this.messages($event)"
                                        @editPart="partEdit($event)"
                                    >

                                    </part-list>
                               

                                   <add-part 
                                   @msg="this.messages($event)"
                                   :ide="this.carId"
                                   v-else-if="this.navList[3].visible"
                                   :edit="this.editPart"
                                   >

                                   </add-part>

                        </transition> 

                  </div>  
           

          
        </div>
</template>

<script>
import dayjs from 'dayjs';
import carsList from './carsList.vue';
import Part from './part.vue';
import NewCar from './newCar.vue';
import AddPart from './addPart.vue';
import axios from 'axios'

var id = 0
export default {
  components: { carsList, Part, NewCar, AddPart },
    props:{
        dataCars:{
            type:Object,
            default:'nopArray'
        }
    },
    data () {    

        return {
           partId:null,
           carsData:this.dataCars,

           partData:[],
           tableContend:false,


           editIdCar:null,
           ifEditCar:false,

           carId:null,

           message:false,
           textMsg:'',
           back:false,

           iconDel:false,

           editPart:false,

           searchItem:'',
           searchData:[],
           
           
           navList:[
              {id:id++ , name:'cars-list' , visible:true},
              {id:id++ , name:'new-cars-part' , visible:false},
              {id:id++ , name:'part-list' , visible:false },
              {id:id++ , name:'add-part' , visible:false },
            
           
          ]

           
          
        }


    },watch:{
        searchItem:function(val){
            if(val.length > 2 ){
                axios.post('search',{item:this.searchItem}).then(res=>{
                      this.searchData = res.data
                })
            }

            if(val.length == 0){
                 this.searchData = []
            }
        }
    },
     mounted(){     
 
    },
    methods:{  
      visible(data){
          this.navList.filter(item=>{
              if(item.id == data){
                  setTimeout(()=>{item.visible = true},100) 
                  data == 0 ? this.back = false : this.back = true
              }else{
                  item.visible = false
              }
          })

      },
      formatDate(dateString) {
                    const data = dayjs(dateString);                      
                    return data.format('DD.MM.YYYY HH:mm:ss');
                   
         },   
       dataPart(data){
          this.partData = data
          this.navList.filter(item=>{ item.id ==  2 ? setTimeout(()=>{item.visible = true},100)  : item.visible = false})
          this.back = true
       },
       editCar(data){
          this.navList.filter(item=>{ item.id ==  1 ? setTimeout(()=>{item.visible = true},100)  : item.visible = false})
          this.ifEditCar = true;
          this.editIdCar = data;
          this.back = true
       },
       messages(data){
           this.message = data.visible 
           this.textMsg = data.text      
           
            if(data.text === 'Deleted'){
              this.navList.filter(item=>{item.visible = false})
              this.iconDel = true
              this.back = false
            }
         
           setTimeout(()=>{
               this.message = false
               this.textMsg = ''
               this.navList.filter(item=>{item.id ==  0 ? setTimeout(()=>{  this.back = false ,this.iconDel = false ,item.visible = true},100)  : item.visible = false})
           },1000)

       },
       appedNewData(data){
           var ide = this.dataCars.length
           var lastId = null;
           var updatedTime = ''
            this.dataCars.filter(item=>{
                if(item.id == ide-1 ){
                    lastId = this.dataCars[item.id].id
                    updatedTime = this.dataCars[item.id].updated_at
                   
                }
            })                            

           this.dataCars.push({id:lastId,name:data.name,part:[],created_at:{edit:true},
              updated_at:updatedTime,
              registration_number:data.registrationNumber,is_registered:data.register
           
           })
       },
        partAdd(data){
             this.carId = data  
             this.back = true
             this.editPart = false
             this.navList.filter(item=>{ item.id ==  3 ? setTimeout(()=>{item.visible = true},100)  : item.visible = false})   
       },
       partEdit(data){
           this.navList.filter(item=>{ item.id ==  3 ? setTimeout(()=>{item.visible = true},100)  : item.visible = false}) 
           this.carId = data  
           this.editPart = true
       }       

    },
}
</script>

<style lang="scss" scoped>


        .v-enter-active{
          transition: opacity 0.5s ease;
          
        }
        .v-leave-active {
          transition: opacity 0.05s ease;
         
        }

        .v-enter-from,
        .v-leave-to {
        opacity: 0;
        }
        

        .slide-fade-enter-active {
            transition: all 0.3s ease-out;
            }

            .slide-fade-leave-active {
            transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
            }

            .slide-fade-enter-from,
            .slide-fade-leave-to {
            transform: translateX(50px);
            opacity: 0;
            }

        
         .slide-delet-enter-active {
            transition: all 0.3s ease-out;
            }

            .slide-delet-leave-active {
            transition: all 0.1s cubic-bezier(1, 0.5, 0.8, 1);
            }

            .slide-delet-enter-from,
            .slide-delet-leave-to {
            transform: translateX(50px);
            opacity: 0;
            }


      

</style>