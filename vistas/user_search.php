<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Usuarios</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file path here -->
    <style>
        .search-container {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        #searchForm {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #searchInput {
            width: 300px;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 10px;
        }

        #searchForm button {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
        }

        #searchResults {
            margin-top: 20px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .result-item {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 10px;
            width: 100%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .result-content {
            flex: 1;
        }

        .result-actions a {
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <!-- Contenedor del campo de búsqueda -->
    <div class="search-container">
        <!-- Formulario de búsqueda -->
        <form id="searchForm">
            <input type="text" id="searchInput" name="searchQuery" placeholder="Buscar usuarios por nombre o usuario" />
            <button type="submit" class="button is-info is-small">Buscar</button>
        </form>
    </div>
    <!-- Contenedor para los resultados de búsqueda -->
    <div id="searchResults"></div>

    <script>
        // Agregar un event listener al formulario
        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault();
            let searchQuery = document.getElementById('searchInput').value.trim();
            
            // Enviar la consulta de búsqueda al servidor
            fetch('https://sanagustinvirtual.co/SGC/vistas/usuario_search.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `searchQuery=${encodeURIComponent(searchQuery)}`
            })
            .then(response => response.text())
            .then(data => {
                // Actualizar el contenedor de resultados con los datos recibidos
                document.getElementById('searchResults').innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
