<p class="has-text-left pt-4 pb-4">
    <a href="#" class="button1 custom-button btn-back">
        <i class="fas fa-arrow-left"></i> Regresar atrás
    </a>
</p>

<script type="text/javascript">
    let btn_back = document.querySelector(".btn-back");

    btn_back.addEventListener('click', function(e){
        e.preventDefault();
        window.history.back();
    });
</script>
<style>
    /* Estilos opcionales para el modal */
    .modal-card-head,
    .modal-card-foot {
        justify-content: space-between;
    }

    /* Estilos personalizados para los botones */
    .custom-button {
        color: #fa6d7d; /* Color del texto */
        border-radius: 5px; /* Radio del borde para un efecto redondeado */
        transition: background-color 0.3s ease; /* Transición suave para cambios de color */
    }

    .custom-button:hover {
    }

    .custom-button i {
        margin-right: 0.5em; /* Espacio entre el ícono y el texto */
    }

    /* Ocultar flechas en los menús desplegables */
    .navbar-item.has-dropdown.is-hoverable .navbar-link {
        background: none; /* Quitar el fondo */
    }

    .navbar-item.has-dropdown.is-hoverable .navbar-link::after {
        display: none; /* Ocultar el indicador de flecha */
    }
</style>
