var role = document.getElementById('role').value; 
$(document).ready(function() {
    // Función de búsqueda en tiempo real
    $('#search').keyup(function() {
        let search = $(this).val(); // Captura el valor del input de búsqueda
        console.log(search);
        if (search) {
            $.ajax({
                url: urlBuscar, // URL de la acción de búsqueda
                type: "GET",
                data: { search: search }, // Parámetro de búsqueda
                success: function(response) {
                    console.log(response);
                    if (response.length > 0) {
                        let template = '';
                        let acciones = '';
                        response.forEach(function(task) {
                            if (role === 'administrador') {
                                cargo = `<td>${task.cargo}</td>`;
                                                acciones = `
                                                  <td>
                                                    <a href="${routeFormularioEditar.replace(':id', task.id)}">
                                                        <i class="fa-solid fa-pen"></i> Modificar
                                                    </a>
                                                
                                                        <form action="${routeEliminar.replace(':id', task.id)}" method="POST" onsubmit="return pregunta()">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token" value="${csrfToken}">
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="fa-solid fa-trash"></i> Eliminar
                                                            </button>
                                                        </form>
                                                    
                                                </td>
                                                `;
                            }
                            else if(role === 'usuario'){
                                cargo = '';
                                acciones = '';
                            }
                            template += `
                                <tr> 
                                    <td>${task.id}</td>
                                    <td>${task.nombre}</td>
                                    <td>${task.marca}</td>
                                    <td>${task.modelo}</td>
                                    <td>${task.ram}</td>
                                    <td>${task.procesador}</td>
                                    <td>${task.almacenamiento}</td>
                                    <td>${task.dir_mac}</td>
                                    <td>${task.perifericos}</td>
                                    <td>${task.observaciones}</td>
                                    <td>${task.categoria}</td>
                                    <td>${task.contraseña}</td>
                                    ${acciones}
                                </tr>
                            `;
                        });
                        $('#resultados-equipos').html(template); // Actualiza la tabla de resultados
                    } else {
                        $('#resultados-equipos').html("<tr><td colspan='10'>No se encontraron resultados</td></tr>");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", error);
                }
            });
        }
    });
});
function pregunta() {
    return confirm('¿Estás seguro de que deseas eliminar este equipo?');
}
