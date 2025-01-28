console.log("busqueda");

var role = document.getElementById('role').value; // Obtener el rol del usuario desde un elemento en el DOM

console.log(role);
$("#search").keyup(function () {
    let search = $("#search").val(); // Capturar el valor del input
    console.log(search);
    if (search) {
        $.ajax({
            url: urlBuscar, // Ruta de Laravel para la búsqueda
            type: "POST",
            data: { search: search,
                _token: $('meta[name="csrf-token"]').attr('content'), // Añadir el token CSRF
            },
            success: function (response) {
                console.log(response);
                try {
                    if (response && response.length > 0) {
                        let template = "";
                        response.forEach((task) => {

                            // Aquí agregamos la condición para mostrar los botones
                            let acciones = '';
                            if (role === "administrador") {
                                cargo = `<td>${task.cargo}</td>`;
                                acciones = `
                                <td>
                                    <a href='/usuarios/modificar/${(task.id)}'>
                                        <i class='fa-solid fa-pen'></i> Modificar
                                    </a>
                                    <a href='/usuarios/eliminar/${(task.id)}' onclick='return confirm("¿Estás seguro de eliminar este usuario?")'>
                                        <i class='fa-solid fa-trash'></i> Eliminar
                                    </a>
                                </td>
                                `;
                            } else if (role === "usuario") {
                                cargo = ``;
                                acciones = ``;
                            }

                            template += `
                                <tr> 
                                    <td>${task.id}</td>
                                    <td>${task.dni}</td>
                                    <td>${task.nombre}</td>
                                    <td>${task.apellidos}</td>
                                    <td>${task.telefono}</td>
                                    <td>${task.direccion}</td>
                                    <td>${task.correo}</td>
                                    ${cargo}
                                    ${acciones}
                                </tr>
                            `;
                        });
                        $("#resultados-usuarios").html(template); // Insertar la tabla en el HTML
                    } else {
                        $("#resultados-usuarios").html("<tr><td colspan='10'>No se encontraron resultados</td></tr>");
                    }
                } catch (e) {
                    console.error("Error al parsear JSON:", e);
                    console.log("Respuesta del servidor:", response);
                    $("#resultados-usuarios").html("<tr><td colspan='10'>Error al procesar la solicitud</td></tr>");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error en la solicitud AJAX:", error);
            },
        });
    }
});
