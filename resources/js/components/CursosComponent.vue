<template>
    <div>
        <form @submit.prevent="EditarDato(dato)" v-if="editarActivo">
        <h3>Agregar Curso</h3>
        <input type="text" placeholder="Curso" class="form-control mb-2" v-model="dato.nombre">  
        <select class="form-control mb-2" v-model="dato.nombre_id" @click.prevent="traer_datos"> 
            <option disabled value="">Seleccione un nombre</option>
            <option v-for="nombre in nombres" v-bind:value="nombre.id">
                    {{ nombre.nombre }}
                </option>
        </select>    
        <select class="form-control mb-2" v-model="dato.institucion_id" @click.prevent="traer_datos">
            <option disabled value="">Seleccione una institución</option>
            <option v-for="institucion in instituciones" v-bind:value="institucion.id">
                    {{ institucion.nombre }}
                </option>
        </select>      
        <button class="btn btn-primary" type="submit">+ Crear</button>
        </form>
        <form @submit.prevent="agregar" v-else>
        <h3>Agregar Curso</h3>
        <input type="text" placeholder="Curso" class="form-control mb-2" v-model="dato.nombre">  
        <select class="form-control mb-2" v-model="dato.nombre_id" @click.prevent="traer_datos"> 
            <option disabled value="">Seleccione un nombre</option>
            <option v-for="nombre in nombres" v-bind:value="nombre.id">
                    {{ nombre.nombre }}
                </option>
        </select>    
        <select class="form-control mb-2" v-model="dato.institucion_id" @click.prevent="traer_datos">
            <option disabled value="">Seleccione una institución</option>
            <option v-for="institucion in instituciones" v-bind:value="institucion.id">
                    {{ institucion.nombre }}
                </option>
        </select>      
        <button class="btn btn-primary" type="submit">+ Crear</button>
        </form>
         <hr>
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Institución</th>
                <th scope="col">Curso</th>
                <th scope="col">Nombre</th>
                <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(dat,index) in cursos" :key="index">
                <th scope="row">{{dat.id}}</th>
                <td>{{dat.nombre2}}</td>
                <td>{{dat.nombre}}</td>
                <td>{{dat.nombre1}} {{dat.apellido}}</td>
                <td><button class="btn btn-warning btn-xs" @click="EditarCurso(dat)">Editar</button>
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
            nombres: [],
            cursos: [],
            instituciones: [],
            dato: {nombre:'',nombre_id:'',institucion_id:''},
            editarActivo:false
        }
    },
    created(){
        axios.get('/nombres').then(res=>{
            this.nombres = res.data;
        }),
        axios.get('/instituciones').then(res=>{
            this.instituciones = res.data;
        }),
        axios.get('/cursos').then(res=>{
            this.cursos = res.data;
        })
    },
    methods:{
        traer_datos(){
            axios.get('/nombres').then(res=>{
                this.nombres = res.data;
            }),
            axios.get('/instituciones').then(res=>{
                this.instituciones = res.data;
            }),
            axios.get('/cursos').then(res=>{
                this.cursos = res.data;
            })
        },        
        EliminarNombre(dat,index){
            axios.delete(`/cursos/${dat.id}`)
                .then(()=>{
                    this.datos.splice(index,1);
                })
            
        },
        agregar(){
                if(this.dato.nombre.trim() === ''){
                    alert('Debes completar todos los campos antes de guardar');
                    return;
                }
                const datoNuevo = this.dato;
                this.dato = {nombre:''};    
                axios.post('/cursos', datoNuevo)
                    .then((res) =>{
                    const datoServidor = res.data;
                    this.datos.push(datoServidor);
                    })
            },
        EditarCurso(dat){
           this.editarActivo = true;
           this.dato.nombre = dat.nombre;
           this.dato.nombre_id = dat.nombre_id;
           this.dato.institucion_id = dat.institucion_id;
           this.dato.id = dat.id;
            
        },
        EditarDato(dato){
            const params = {nombre: dato.nombre,nombre_id:dato.nombre_id,institucion_id:dato.institucion_id}
            axios.put(`/cursos/${dato.id}`,params)
                .then(()=>{
                    alert("se actualizo correctamente")
                    axios.get('/cursos').then(res=>{
                    this.datos = res.data;
                    this.dato = {nombre:'',nombre_id:'',institucion_id:''}; 
                    this.editarActivo = false;
                    })
                })
            
        }
    }
}
</script>