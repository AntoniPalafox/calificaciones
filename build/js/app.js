document.addEventListener('DOMContentLoaded', function() {
    obtenerUrl();
    agregarMateria();
    consultarAPI();
    
});


function agregarMateria(){

    const campos = document.getElementById("agregarMateria");
    if (campos) {
        campos.addEventListener("click", e => {
            e.preventDefault()
            const campos = document.createElement('DIV')
            campos.classList.add('md:flex', 'py-3')
            campos.innerHTML = `<div class=" md:w-1/2 px-1">
            <label for="nombre_materia" class=" block text-gray-700 uppercase font-bold">Nombre Materia: </label>
            <input type="text" name="nombre_materia[]" class=" border-2 w-full p-2 mt-2 placeholder-gray-400 rounded-md">
        </div>
        <div class=" md:w-1/2 px-1">
            <label for="docente" class=" block text-gray-700 uppercase font-bold">Nombre del docente: </label>
            <input type="text" name="docente[]" class=" border-2 w-full p-2 mt-2 placeholder-gray-400 rounded-md mb-6 md:mb-0">
        </div>`;
    
        // Insertar en el HTML
        const formulario = document.querySelector('#formularioGrupo');
        formulario.appendChild(campos);
        });
    }
    
    
    
    
}

function obtenerUrl(){
    const url = window.location.search;
    if(url){
        let frag = url.split('?')

        if(frag){
            let fragmentos = frag[1].split('&')

            fragmentos.forEach( element => {
                let identificadores = element.split('=').join('')
                console.log(identificadores);
                let id = document.getElementById(identificadores)
                if (id.classList.contains('bg-blue-600')) {
                    id.classList.remove('bg-blue-600')
                }
                
                id.classList.add('bg-blue-900')
            })  
        }
    }
}

function consultarAPI(){

    url = 'http://localhost/calificaciones/admin/maestros.php/';
    fetch(url)
        .then(respuesta =>respuesta.json())
        .then(resultado => console.log(resultado))
        .catch(error => console.log(error))
}