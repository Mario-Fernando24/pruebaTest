<template>
    
<main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Usuario
                        <button type="button"  @click="abrirModal('cliente','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Añadir
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="apellido">Apellido</option>
                                      <option value="ciudad">Ciudad</option>

                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listar_cliente(1,buscar,criterio)"  class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listar_cliente(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Ciudad</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="cliente in arrayCliente" :key="cliente.id">
                                    <td v-text="cliente.nombre"></td>
                                    <td v-text="cliente.apellido"></td>
                                    <td v-text="cliente.ciudad"></td>
                                    <td>
                                        <span v-if="cliente.estado" class="badge badge-success">Activo</span>
                                         <span v-else class="badge badge-danger">Inactivo</span>

                                    </td>

                                    <td>
                                        <button type="button"  @click="abrirModal('cliente', 'actualizar',cliente)"   class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#modalNuevo">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;

                                    <template v-if="cliente.estado"> 
                                        <button type="button"  class="btn btn-outline-danger btn-sm" @click="desactivarCliente(cliente.id)">
                                            <i class="icon-trash"></i>
                                        </button>
                                        </template>
                                            <template v-else> 
                                        <button type="button"  class="btn btn-outline-success btn-sm" @click="activarCliente(cliente.id)">
                                            <i class="icon-check"></i>
                                        </button>
                                   </template>


                                    </td>
                                </tr>
                            </tbody>
                        </table>
                            <nav>

                                <ul class="pagination">
                                                                    <!--si la pagina actual > que 1-->

                                <li class="page-item" v-if="pagination.current_page > 1 ">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                                                <!--iteramos la propiedad computada-->

                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>

                        </nav>

                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
              <div class="modal fade"  tabindex="-1" :class="{'mostrar':modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()"  aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-bod">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                               
                                            <div class="form-group row">
                                               <div class="col-md-6">
                                                   <label class="col-md-6 form-control-label text-negrita" for="text-input">Tipo Documento</label>
                                                        <select v-model="cliente.tipo_documento" class="form-control"  >
                                                            <option value="ti">Tarjeta de identidad</option>
                                                            <option value="cc">Cedula</option>
                                                            <option value="te">Tarjeta de extranjero</option>
                                                        </select>
                                                </div>


                                                <div class="col-md-6">
                                                <label class="col-md-6 form-control-label text-negrita" for="text-input">Numero Documento</label>
                                                    <input type="number" v-model="cliente.num_documento"   class="form-control" required placeholder="Numero de documento">
                                                    <span class="text-error"  v-if="validate==true && cliente.num_documento.length<=0">Numero de documento es obligatorio</span>
                                                </div>
                                           </div>



                                            <div class="form-group row">
                                               <div class="col-md-4">
                                                   <label class="col-md-3 form-control-label text-negrita" for="text-input">Nombre</label>
                                                    <input type="text" v-model="cliente.nombre"  class="form-control" required placeholder="Nombre">
                                                     <span class="text-error"  v-if="validate==true && cliente.nombre.length<=0">Nombre es obligatorio</span>
                                                </div>

                                                <div class="col-md-4">
                                                <label class="col-md-3 form-control-label text-negrita" for="text-input">Apellido</label>
                                                    <input type="text" v-model="cliente.apellido"   class="form-control" required placeholder="Apellido">
                                                    <span class="text-error"  v-if="validate==true && cliente.apellido.length<=0">Apellido es obligatorio</span>
                                                </div>


                                                <div class="col-md-4">
                                                <label class="col-md-3 form-control-label text-negrita" for="text-input">Ciudad</label>
                                                    <input type="text" v-model="cliente.ciudad"  class="form-control" required placeholder="Ciudad">
                                                     <span class="text-error"  v-if="validate==true && cliente.ciudad.length<=0">Ciudad es obligatorio</span>
                                                </div>
                                           </div>


                                             <div class="form-group row">
                                                <div class="col-md-12">

                                                      <GmapMap
                                                        :center="center"
                                                        :zoom="18"
                                                        map-style-id="roadmap"
                                                        :options="mapOptions"
                                                        style="width: 100vmin; height: 50vmin"
                                                        ref="mapRef"
                                                        @click="handleMapClick"
                                                    >
                                                        <GmapMarker
                                                        :position="marker.position"
                                                        :clickable="true"
                                                        :draggable="true"
                                                        @drag="handleMarkerDrag"
                                                        @click="panToMarker"
                                                        />
                                                    </GmapMap>
                                                    <!-- <button class="btn btn-outline-danger btn-sm" @click="geolocate">Buscar mi ubicacion</button> -->

                                                    <!-- <p>Selected Position: {{ marker.position }}</p> -->



                                                </div>   

                                             </div>


                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" v-if="tipoAccionButton==1" class="btn btn-primary" @click="registrarCliente()">Guardar</button>
                            <button type="button" v-if="tipoAccionButton==2" class="btn btn-primary" @click="actualizarCliente()">Editar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            <!-- Inicio del modal Eliminar -->
            <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialo modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Eliminar Categoría</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-bod">
                            <p>Estas seguro de eliminar la categoría?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-danger">Eliminar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- Fin del modal Eliminar -->
        </main>
</template>

<script>
    export default {
       data(){
          return {

               marker: { position: { lat: 10, lng: 10 } },
      center: { lat: 10, lng: 10 },

      mapOptions: {
        disableDefaultUI: true,
      },

           
          cliente:{
             id:'',
             tipo_documento:'ti',
             num_documento:'',
             nombre:'',
             apellido:'',
             ciudad:'',
             latitud:'',
             longitud:'',
             estado:''
          },

          

          arrayCliente:[],
          tituloModal : '',
          tipoAccionButton : 0,   
          modal:0,
          pagination : {
            //numero total de registro
            'total' : 0,
            //Obtenga el número de página actual.
            'current_page' : 0,
            //El número de elementos que se mostrarán por página.
            'per_page' : 0,
            //  Obtenga el número de página de la última página disponible. (No disponible cuando se usa simplePaginate).
            'last_page' : 0,
            //desde la pagina
            'from'  : 0,
            //hasta pagina
            'to' : 0,
          },
            offset : 3,
            criterio : 'nombre',
            buscar  : '',
            errorCliente : 0,
            errorMensajeClienteArray: [],
            validate:false,

          }
        },
        //Propiedad computada declaramos unas funciones
        computed :{
           
        //calcular la pagina actual
            isActived : function(){
              return   this.pagination.current_page
            },
            //calcular el numero de paginas
            pagesNumber : function(){
                if(!this.pagination.to){
                    return [];
                }
                var from = this.pagination.current_page - this.offset; 
                if(from < 1){
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if(to >=  this.pagination.last_page){
                    to = this.pagination.last_page;
                }
                var pagesArray = [];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;  
            }
        },
        methods: {


                            //detects location from browser
                    geolocate() {
                    navigator.geolocation.getCurrentPosition((position) => {
                        this.marker.position = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                        };

                        this.panToMarker();
                    });
                    },

                    //sets the position of marker when dragged
                    handleMarkerDrag(e) {
                    this.marker.position = { lat: e.latLng.lat(), lng: e.latLng.lng() };
                    },

                    //Moves the map view port to marker
                    panToMarker() {
                    this.$refs.mapRef.panTo(this.marker.position);
                    this.$refs.mapRef.setZoom(18);
                    },

                    //Moves the marker to click position on the map
                    handleMapClick(e) {
                    this.marker.position = { lat: e.latLng.lat(), lng: e.latLng.lng() };
                    console.log(e);
                    },



        
          listar_cliente(page, buscar, criterio){
                 let me=this;
                  var url= '/cliente/allCliente?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                  axios.get(url).then(function (response) {
                     var respuesta = response.data;
                     console.log(respuesta);
                    // //todo lo que retorne esta funcion se almacene en este array
                     me.arrayCliente = respuesta.all_cliente.data;
                     me.pagination = respuesta.pagination;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
              },


        //Metodo de cambiar pagina recibe un parametro de page "numero de la pagina que queremos mostrar"
        cambiarPagina(page, buscar, criterio){
            let me = this;
            //actualiza a la pagina actual
            me.pagination.current_page = page;
            //envia la peticion de listar esa pagina
            me.listar_cliente(page, buscar, criterio);
        },


            registrarCliente(){

                if(this.validarCliente()){return ;}

                  let me=this;
                  axios.post('/cliente/register', {  
                    'tipo_documento':  this.cliente.tipo_documento,
                    'num_documento': this.cliente.num_documento,
                    'nombre': this.cliente.nombre,
                    'apellido': this.cliente.apellido,
                     'ciudad': this.cliente.ciudad,                   
                    'latitud': this.marker.position.lat,  
                    'longitud': this.marker.position.lng,                   
                })
                
                .then(function (response) {
            var respuesta=response.data;
            if(response.data.status){
                    me.cerrarModal();
                    me.listar_cliente(1,'','nombre');
             Swal.fire(
                'Exitoso?',
                'Evento guardado correctamente',
                'success'
                )

            }
                }) 
                .catch(function (error) {
                    console.log(error);
                });
              },





             actualizarCliente(){

                  if(this.validarCliente()){return ;}

                  let me=this;
                  axios.put('/cliente/actualizar', {
                    
                    'tipo_documento':  this.cliente.tipo_documento,
                    'num_documento': this.cliente.num_documento,
                    'nombre': this.cliente.nombre,
                    'apellido': this.cliente.apellido,
                     'ciudad': this.cliente.ciudad,                   
                    'latitud': this.cliente.latitud,  
                    'longitud': this.cliente.longitud,   
                    'id': this.cliente.id 
                }).then(function (response) {
                    me.cerrarModal();
                    me.listar_cliente(1,'','nombre');
                     Swal.fire(
                'Exitoso',
                'Cliente Editado correctamente',
                'success'
                )
                })
                .catch(function (error) {
                    console.log(error);
                });
              },






          abrirModal(modelo, accion, data=[]){
                 switch(modelo){
                       case "cliente":
                      {
                         switch(accion){
                              case 'registrar':
                             {
                                 this.modal=1;
                                 this.tituloModal='Añadir Cliente';
                                 this.tipoAccionButton=1;
                               break;
                              } 
                              case 'actualizar':
                             {
                                 this.modal=1;
                                 this.tituloModal='Actualizar Cliente';
                                 this.tipoAccionButton=2;
                                 this.cliente.tipo_documento=data['tipo_documento']; 
                                 this.cliente.num_documento=data['num_documento']; 
                                 this.cliente.nombre=data['nombre']; 
                                 this.cliente.apellido=data['apellido']; 
                                 this.cliente.ciudad=data['ciudad']; 
                                 this.cliente.id=data['id'];

                               break;
                              } 
                         }

                      }
                 }
           },

           cerrarModal(){
               this.modal=0;
                this.cliente.id='';
                this.cliente.tipo_documento='ti';
                this.cliente.num_documento='';
                this.cliente.nombre='';
                this.cliente.apellido='';
                this.cliente.ciudad='';
                this.cliente.latitud='';
                this.cliente.longitud='';    
                this.validate=false;
      
           },



        validarCliente(){
            this.errorCliente=0;
            this.errorMensajeClienteArray=[];
            if(!this.cliente.tipo_documento) this.errorMensajeClienteArray.push("");
            if(!this.cliente.num_documento) this.errorMensajeClienteArray.push("");
            if(!this.cliente.nombre) this.errorMensajeClienteArray.push("");
            if(!this.cliente.apellido) this.errorMensajeClienteArray.push("");
            if(!this.cliente.ciudad) this.errorMensajeClienteArray.push("");
            
            if(this.errorMensajeClienteArray.length) 
            this.errorCliente=1;
            this.validate=true;
            return this.errorCliente;
        },




            desactivarCliente(id){
               console.log(id);
               const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                title: 'Estas seguro de desactivar este Cliente?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                     let me=this;
                  axios.put('/cliente/desactivar', {
                    'id' : id
                })
                .then(function (response) {
                    me.listar_cliente(1,'','nombre');
                    swalWithBootstrapButtons.fire(
                    'Desactivado',
                    'El Cliente ha sido desactivado correctamente',
                    'success'
                    )
                })
                .catch(function (error) {
                    console.log(error);
                });
                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                    'Cancelado',
                    '',
                    'error'
                    )
                }
                })
           },
            activarCliente(id){
                               console.log(id);
               const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                title: 'Estas seguro de activar este Cliente?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                     let me=this;
                  axios.put('/cliente/activar', {
                    'id' : id
                })
                .then(function (response) {
                    me.listar_cliente(1,'','nombre');
                    swalWithBootstrapButtons.fire(
                    'Activado',
                    'Cliente ha sido Activada correctamente',
                    'success'
                    )
                })
                .catch(function (error) {
                    console.log(error);
                });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                    'Cancelado',
                    '',
                    'error'
                    )
                }
                })
           },
 



          
        },mounted() {
          this.listar_cliente(1,this.buscar,this.criterio);     
          this.geolocate();

         }
    }
</script>


<style>
.modal-content{
    width: 100% !important;
    position: absolute!important;
}
  .mostrar{
      display: list-item !important;
      opacity: 1 !important;
      position: absolute!important;
      background-color: #3c29297a;
  }
  .div-error{
     display: flex;
     justify-content: center;
  }
  .text-error{
    color: red !important;
    font-weight: bold;
  }
   .text-negrita{
    color: black !important;
    font-weight: bold;
  }
  
  .moda{
    display: block !important; /* I added this to see the modal, you don't need this */
}
/* Important part */
.modal-dialo{
    overflow-y: initial !important
}
.modal-bod{
    height: 60vh;
    overflow-y: auto;
    margin: 10px 30px 10px 30px
}
.hiddenFileInput > input{
  height: 100%;
  width: 100;
  opacity: 0;
  cursor: pointer;
}
.hiddenFileInput{
  border: 1px solid #ccc;
  width: 30px;
  height: 30px;
  display: inline-block;
  overflow: hidden;
  cursor: pointer;
  
  /*for the background, optional*/
  background: center center no-repeat;
  background-size: 75% 75%;
  background-image:  url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIj8+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBoZWlnaHQ9IjUxMnB4IiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9Ii01MyAxIDUxMSA1MTEuOTk5MDYiIHdpZHRoPSI1MTJweCI+CjxnIGlkPSJzdXJmYWNlMSI+CjxwYXRoIGQ9Ik0gMjc2LjQxMDE1NiAzLjk1NzAzMSBDIDI3NC4wNjI1IDEuNDg0Mzc1IDI3MC44NDM3NSAwIDI2Ny41MDc4MTIgMCBMIDY3Ljc3NzM0NCAwIEMgMzAuOTIxODc1IDAgMC41IDMwLjMwMDc4MSAwLjUgNjcuMTUyMzQ0IEwgMC41IDQ0NC44NDM3NSBDIDAuNSA0ODEuNjk5MjE5IDMwLjkyMTg3NSA1MTIgNjcuNzc3MzQ0IDUxMiBMIDMzOC44NjMyODEgNTEyIEMgMzc1LjcxODc1IDUxMiA0MDYuMTQwNjI1IDQ4MS42OTkyMTkgNDA2LjE0MDYyNSA0NDQuODQzNzUgTCA0MDYuMTQwNjI1IDE0NC45NDE0MDYgQyA0MDYuMTQwNjI1IDE0MS43MjY1NjIgNDA0LjY1NjI1IDEzOC42MzY3MTkgNDAyLjU1NDY4OCAxMzYuMjg1MTU2IFogTSAyNzkuOTk2MDk0IDQzLjY1NjI1IEwgMzY0LjQ2NDg0NCAxMzIuMzI4MTI1IEwgMzA5LjU1NDY4OCAxMzIuMzI4MTI1IEMgMjkzLjIzMDQ2OSAxMzIuMzI4MTI1IDI3OS45OTYwOTQgMTE5LjIxODc1IDI3OS45OTYwOTQgMTAyLjg5NDUzMSBaIE0gMzM4Ljg2MzI4MSA0ODcuMjY1NjI1IEwgNjcuNzc3MzQ0IDQ4Ny4yNjU2MjUgQyA0NC42NTIzNDQgNDg3LjI2NTYyNSAyNS4yMzQzNzUgNDY4LjA5NzY1NiAyNS4yMzQzNzUgNDQ0Ljg0Mzc1IEwgMjUuMjM0Mzc1IDY3LjE1MjM0NCBDIDI1LjIzNDM3NSA0NC4wMjczNDQgNDQuNTI3MzQ0IDI0LjczNDM3NSA2Ny43NzczNDQgMjQuNzM0Mzc1IEwgMjU1LjI2MTcxOSAyNC43MzQzNzUgTCAyNTUuMjYxNzE5IDEwMi44OTQ1MzEgQyAyNTUuMjYxNzE5IDEzMi45NDUzMTIgMjc5LjUwMzkwNiAxNTcuMDYyNSAzMDkuNTU0Njg4IDE1Ny4wNjI1IEwgMzgxLjQwNjI1IDE1Ny4wNjI1IEwgMzgxLjQwNjI1IDQ0NC44NDM3NSBDIDM4MS40MDYyNSA0NjguMDk3NjU2IDM2Mi4xMTMyODEgNDg3LjI2NTYyNSAzMzguODYzMjgxIDQ4Ny4yNjU2MjUgWiBNIDMzOC44NjMyODEgNDg3LjI2NTYyNSAiIHN0eWxlPSIgZmlsbC1ydWxlOm5vbnplcm87ZmlsbC1vcGFjaXR5OjE7IiBzdHJva2U9IiMwMDAwMDAiIGZpbGw9IiMwMDAwMDAiLz4KPHBhdGggZD0iTSAzMDUuMTAxNTYyIDQwMS45MzM1OTQgTCAxMDEuNTM5MDYyIDQwMS45MzM1OTQgQyA5NC43MzgyODEgNDAxLjkzMzU5NCA4OS4xNzE4NzUgNDA3LjQ5NjA5NCA4OS4xNzE4NzUgNDE0LjMwMDc4MSBDIDg5LjE3MTg3NSA0MjEuMTAxNTYyIDk0LjczODI4MSA0MjYuNjY3OTY5IDEwMS41MzkwNjIgNDI2LjY2Nzk2OSBMIDMwNS4yMjY1NjIgNDI2LjY2Nzk2OSBDIDMxMi4wMjczNDQgNDI2LjY2Nzk2OSAzMTcuNTkzNzUgNDIxLjEwMTU2MiAzMTcuNTkzNzUgNDE0LjMwMDc4MSBDIDMxNy41OTM3NSA0MDcuNDk2MDk0IDMxMi4wMjczNDQgNDAxLjkzMzU5NCAzMDUuMTAxNTYyIDQwMS45MzM1OTQgWiBNIDMwNS4xMDE1NjIgNDAxLjkzMzU5NCAiIHN0eWxlPSIgZmlsbC1ydWxlOm5vbnplcm87ZmlsbC1vcGFjaXR5OjE7IiBzdHJva2U9IiMwMDAwMDAiIGZpbGw9IiMwMDAwMDAiLz4KPHBhdGggZD0iTSAxNDAgMjY4Ljg2MzI4MSBMIDE5MC45NTMxMjUgMjE0LjA3NDIxOSBMIDE5MC45NTMxMjUgMzQ5LjEyNSBDIDE5MC45NTMxMjUgMzU1LjkyNTc4MSAxOTYuNTE5NTMxIDM2MS40OTIxODggMjAzLjMyMDMxMiAzNjEuNDkyMTg4IEMgMjEwLjEyNSAzNjEuNDkyMTg4IDIxNS42ODc1IDM1NS45MjU3ODEgMjE1LjY4NzUgMzQ5LjEyNSBMIDIxNS42ODc1IDIxNC4wNzQyMTkgTCAyNjYuNjQwNjI1IDI2OC44NjMyODEgQyAyNjkuMTEzMjgxIDI3MS40NTcwMzEgMjcyLjMzMjAzMSAyNzIuODIwMzEyIDI3NS42Njc5NjkgMjcyLjgyMDMxMiBDIDI3OC42MzY3MTkgMjcyLjgyMDMxMiAyODEuNzMwNDY5IDI3MS43MDcwMzEgMjg0LjA3ODEyNSAyNjkuNDgwNDY5IEMgMjg5LjAyNzM0NCAyNjQuNzgxMjUgMjg5LjM5ODQzOCAyNTYuOTg4MjgxIDI4NC42OTkyMTkgMjUyLjA0Mjk2OSBMIDIxMi4yMjY1NjIgMTc0LjI1MzkwNiBDIDIwOS44NzUgMTcxLjc4MTI1IDIwNi42NjAxNTYgMTcwLjI5Njg3NSAyMDMuMTk5MjE5IDE3MC4yOTY4NzUgQyAxOTkuNzM0Mzc1IDE3MC4yOTY4NzUgMTk2LjUxOTUzMSAxNzEuNzgxMjUgMTk0LjE3MTg3NSAxNzQuMjUzOTA2IEwgMTIxLjY5OTIxOSAyNTIuMDQyOTY5IEMgMTE3IDI1Ni45ODgyODEgMTE3LjM3MTA5NCAyNjQuOTAyMzQ0IDEyMi4zMTY0MDYgMjY5LjQ4MDQ2OSBDIDEyNy41MTE3MTkgMjc0LjE3OTY4OCAxMzUuMzAwNzgxIDI3My44MDg1OTQgMTQwIDI2OC44NjMyODEgWiBNIDE0MCAyNjguODYzMjgxICIgc3R5bGU9IiBmaWxsLXJ1bGU6bm9uemVybztmaWxsLW9wYWNpdHk6MTsiIHN0cm9rZT0iIzAwMDAwMCIgZmlsbD0iIzAwMDAwMCIvPgo8L2c+Cjwvc3ZnPgo=)
}
</style>
