<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! current_user_can( 'manage_options' ) ) {
    return;
}

if ( isset( $_POST['prixz_save_settings'] ) ) {
    update_option( 'prixz_minimum_purchase', sanitize_text_field( $_POST['prixz_minimum_purchase'] ) );
    update_option( 'prixz_minimum_purchase_message', sanitize_text_field( $_POST['prixz_minimum_purchase_message'] ) );
    update_option( 'prixz_remaining_message', sanitize_text_field( $_POST['prixz_remaining_message'] ) );
    echo '<div class="updated"><p>Configuraciones guardadas</p></div>';
}

$minimum_purchase = get_option( 'prixz_minimum_purchase', 0 );
$minimum_purchase_message = get_option( 'prixz_minimum_purchase_message', 'Lo siento, debes juntar al menos %s en tu carrito para poder comprar en la tienda.' );
$remaining_message = get_option( 'prixz_remaining_message', 'Te faltan %s.' );

?>


<div class="wrap">
    <h1>Configuración Mínimo de Compra</h1>

    <h2>Instrucciones</h2>
    <p>Configura el monto mínimo de compra y el mensaje de error que se mostrará cuando el total del carrito sea inferior al mínimo establecido.</p>
    <ul>
        <li><strong>Monto mínimo de compra:</strong> Ingresa el monto mínimo que el carrito debe alcanzar para permitir la compra.</li>
        <li><strong>Mensaje de error:</strong> Personaliza el mensaje de error. Usa <code>%s</code> para insertar el monto mínimo en el mensaje.</li>
        <li><strong>Mensaje de cantidad faltante:</strong> Personaliza el mensaje que muestra cuánto falta para alcanzar el mínimo. Usa <code>%s</code> para insertar la cantidad faltante.</li>
    </ul>

    <form method="post">
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Monto mínimo de compra</th>
                <td>
                    <input type="number" name="prixz_minimum_purchase" value="<?php echo esc_attr( $minimum_purchase ); ?>" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Mensaje de error</th>
                <td>
                    <input type="text" name="prixz_minimum_purchase_message" value="<?php echo esc_attr( $minimum_purchase_message ); ?>" size="50" />
                    <p class="description">Usa <code>%s</code> para insertar el monto mínimo.</p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Mensaje de cantidad faltante</th>
                <td>
                    <input type="text" name="prixz_remaining_message" value="<?php echo esc_attr( $remaining_message ); ?>" size="50" />
                    <p class="description">Usa <code>%s</code> para insertar la cantidad faltante.</p>
                </td>
            </tr>

        </table>
        <?php submit_button( 'Guardar configuraciones', 'primary', 'prixz_save_settings' ); ?>
    </form>

 

    <h2>Shortcode para mostrar el mensaje</h2>
    <p>Utiliza el siguiente shortcode para mostrar el mensaje de mínimo de compra en cualquier parte del sitio:</p>
    <p><code>[prixz_minimo_compra_msg]</code></p>
</div>
