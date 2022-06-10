<template>
   
        <div class="part-list">
                <h1 style="text-align: center; padding: 0rem 0rem 1rem;">{{title}}</h1>  
                
              <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Part table</th>
                    <th scope="col">Name</th>
                    <th scope="col">Serial number</th>
                    <th scope="col">Last updated</th>
                    </tr>
                </thead>
                <tbody>
                  <h1 v-if="ifSelected" style="padding:1rem; font-size: 1rem; border-bottom: 2px solid lightgray;">Selecte</h1>   
                   <tr class="table-success" v-if="ifSelected">
                    <th scope="row">{{ this.selected.id}}</th>
                        <td>{{this.selected.name}}</td>
                        <td>{{this.selected.serial_number}}</td>
                        <td>{{formatDate(this.selected.updated_at)}}</td>                    
                      <td style="text-align: center;"><button @click="editPart(this.selected.id)" style="margin-left: .3rem; padding: 0.1rem 0.3rem;" type="button" class="btn btn-success btn-sm">Edit part</button></td>
                      <td style="text-align: center;"><button @click="deletePart(this.selected.id)" style="font-size:.7rem; margin-left: .3rem; padding: 0.1rem 0.3rem;" type="button" class="btn btn-btn btn-danger btn-sm">Delete</button></td>   
           
                   </tr>
                    <h1  v-if="ifSelected" style="padding:1rem; font-size: 1rem; border-bottom: 2px solid lightgray;">All Cars</h1>        
                    <tr class="table-light" v-for="item in this.object" :key="item.id">
                        <th scope="row">{{item.id}}</th>
                            <td>{{item.name}}</td>
                            <td>{{item.serial_number}}</td>
                            <td>{{formatDate(item.updated_at)}}</td>
                      <td style="text-align: center;"><button @click="editPart(item.id)" style="margin-left: .3rem; padding: 0.1rem 0.3rem;" type="button" class="btn btn-success btn-sm">Edit part</button></td>
                      <td style="text-align: center;"><button @click="deletePart(item.id)" style="font-size:.7rem; margin-left: .3rem; padding: 0.1rem 0.3rem;" type="button" class="btn btn-btn btn-danger btn-sm">Delete</button></td>                        
                     </tr>              
                </tbody>
            </table>

        </div>
        
          
       
</template>

<script>
import dayjs from 'dayjs';
import axios from 'axios'
export default {
    emits:['editPart','msg'],
    props:{
      partData:{
          type:Object,
          default:'nopData'
      }
    },
    data () {
        

        return {
            
            selected:'',
            object:'',
           

            title:'Part list',
            ifSelected:false,

        }
    },
    mounted() {
       this.checked()
    },
    methods: {
        checked(){
            var selectedData = ''
                    
             if(this.partData.selected == null){
                
                  this.object = this.partData.part
                  this.ifSelected = false                      
             }else{                             
               
                 this.partData.part.filter(item=>{                                
                   item.id == this.partData.selected ? selectedData = item : '' })
                 this.selected = selectedData
                 this.object = this.partData.part
                 this.ifSelected = true                  
                 
             }
        },
        formatDate(dateString) {
                    const data = dayjs(dateString);                      
                    return data.format('DD.MM.YYYY HH:mm:ss');
                   
         },   
         deletePart(data){
             if(confirm('definitely delete')){
                 axios.delete('part/'+data).then(res=>{
                    this.$emit('msg',{visible:true,text:'Deleted'})
                 }).catch(e=>{
                     this.$emit('msg',{visible:true,text:'Nop deleted'})
                 });
             }
         },
         editPart(data){
               this.$emit('editPart',data)
         }

    }
}
</script>

<style lang="scss" scoped>



</style>