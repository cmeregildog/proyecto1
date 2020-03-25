<template>
    <div>
        <form @submit.prevent="EditarDato(dato)" v-if="editarActivo">
        <h3>Editar Institución</h3>
        <input type="text" placeholder="Nombres" class="form-control mb-2" v-model="dato.nombre">        
        <button class="btn btn-warning" type="submit">Editar</button>
        </form>
        <form @submit.prevent="agregar" v-else>
        <h3>Agregar Institución</h3>
        <input type="text" placeholder="Nombres" class="form-control mb-2" v-model="dato.nombre">        
        <button class="btn btn-primary" type="submit">+ Crear</button>
        </form>
        <hr>
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Tipo Institución</th>
                <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(dat,index) in datos" :key="index">
                <th scope="row">{{dat.id}}</th>
                <td>{{dat.nombre}}</td>
                <td><button class="btn btn-warning btn-xs" @click="EditarInstitucion(dat)">Editar</button>
                <button class="btn btn-danger btn-xs" @click="EliminarNombre(dat,index)">Eliminar</button></td>
                </tr>
               
            </tbody>
            </table>
    </div>
</template>
<script>
export default {
    data(){
        return{
            datos: [],
            dato: {nombre:''},
            editarActivo:false
        }
    },
    created(){
        axios.get('/instituciones').then(res=>{
        this.datos = res.data;
        })
    },
    methods:{
        agregar(){
                if(this.dato.nombre.trim() === ''){
                    alert('Debes completar todos los campos antes de guardar');
                    return;
                }
                const datoNuevo = this.dato;
                this.dato = {nombre:''};    
                axios.post('/instituciones', datoNuevo)
                    .then((res) =>{
                    const datoServidor = res.data;
                    this.datos.push(datoServidor);
                    })
            },
        EliminarNombre(dat,index){
            axios.delete(`/instituciones/${dat.id}`)
                .then(()=>{
                    this.datos.splice(index,1);
                })
            
        },
        EditarInstitucion(dat){
           this.editarActivo = true;
           this.dato.nombre = dat.nombre;
           this.dato.id = dat.id;
            
        },
        EditarDato(dato){
            const params = {nombre: dato.nombre}
            axios.put(`/instituciones/${dato.id}`,params)
                .then(()=>{
                    alert("se actualizo correctamente")
                    axios.get('/instituciones').then(res=>{
                    this.datos = res.data;
                    this.dato = {nombre:''}; 
                    this.editarActivo = false;
                    })
                })
            
        }
    }
}
</script>