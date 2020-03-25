<template>
    <div>
        <form @submit.prevent="EditarDato(dato)" class="mb-2" v-if="editarActivo">
            <h3>Editar Nombres</h3>
            <input type="text" placeholder="Nombres" class="form-control mb-2" v-model="dato.nombre">
            <input type="text" placeholder="Apellidos" class="form-control mb-2" v-model="dato.apellido">
            <input type="number" placeholder="Edad" class="form-control mb-2" v-model="dato.edad">
            
            <button class="btn btn-warning" type="submit">Actualizar</button>
        </form>
        <form @submit.prevent="agregar" class="mb-2" v-else>
            <h3>Agregar Nombres</h3>
            <input type="text" placeholder="Nombres" class="form-control mb-2" v-model="dato.nombre">
            <input type="text" placeholder="Apellidos" class="form-control mb-2" v-model="dato.apellido">
            <input type="number" placeholder="Edad" class="form-control mb-2" v-model="dato.edad">
            
            <button class="btn btn-primary" type="submit">+ Crear</button>
        </form>
        <hr>
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Nombres</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Edad</th>
                <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(dat,index) in datos" :key="index">
                <th scope="row">{{dat.id}}</th>
                <td>{{dat.nombre}}</td>
                <td>{{dat.apellido}}</td>
                <td>{{dat.edad}}</td>
                <td><button class="btn btn-warning btn-xs" @click="EditarNombre(dat)">Editar</button>
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
            dato: {nombre:'',apellido:'',edad:''},
            editarActivo: false
        }
    },
    created(){
        axios.get('/nombres').then(res=>{
        this.datos = res.data;
        })
    },
    methods:{
        agregar(){
                if(this.dato.nombre.trim() === '' || this.dato.apellido.trim() === ''){
                    alert('Debes completar todos los campos antes de guardar');
                    return;
                }
                const datoNuevo = this.dato;
                this.dato = {nombre:'',apellido:'',edad:''};    
                axios.post('/nombres', datoNuevo)
                    .then((res) =>{
                    const datoServidor = res.data;
                    this.datos.push(datoServidor);
                    })
            },
        EliminarNombre(dat,index){
            axios.delete(`/nombres/${dat.id}`)
                .then(()=>{
                    this.datos.splice(index,1);
                })
            
        },
        EditarNombre(dat){
           this.editarActivo = true;
           this.dato.nombre = dat.nombre;
           this.dato.apellido = dat.apellido;
           this.dato.edad = dat.edad;
           this.dato.id = dat.id;
            
        },
        EditarDato(dato){
            const params = {nombre: dato.nombre, apellido: dato.apellido, edad:dato.edad}
            axios.put(`/nombres/${dato.id}`,params)
                .then(()=>{
                    alert("se actualizo correctamente")
                    axios.get('/nombres').then(res=>{
                    this.datos = res.data;
                    this.dato = {nombre:'',apellido:'',edad:''}; 
                    this.editarActivo = false;
                    })
                })
            
        }
    }
}
</script>