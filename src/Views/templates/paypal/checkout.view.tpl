<h1>Tu Carrito</h1>

<table>
  <thead>
    <tr>
      <th>Producto</th>
      <th>Precio</th>
      <th>Cantidad</th>
      <th>Subtotal</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    {{foreach items}}
      <tr>
        <td>{{productName}}</td>
        <td>{{crrprc}}</td>
        <td>{{crrctd}}</td>
        <td>{{itemSubtotal}}</td>
        <td>
          <!-- Disminuir -->
          <form action="index.php?page=Checkout_Checkout" method="post" style="display:inline">
            <input type="hidden" name="productId" value="{{productId}}">
            <button type="submit" name="decrease">−</button>
          </form>
          <!-- Aumentar -->
          <form action="index.php?page=Checkout_Checkout" method="post" style="display:inline">
            <input type="hidden" name="productId" value="{{productId}}">
            <button type="submit" name="increase">+</button>
          </form>
        </td>
      </tr>
    {{endfor items}}
  </tbody>
</table>

<p><strong>Total:</strong> L.{{subTotal}}</p>

<form action="index.php?page=Checkout_Checkout" method="post">
</form>

<div id="paypal-button-container"></div>
<script src="https://www.paypal.com/sdk/js?client-id=sb&currency=USD"></script>
<script>
  paypal.Buttons({
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{ amount: { value: "{{total}}" } }]
      });
    },
    onApprove: function(data, actions) {
      return actions.order.capture().then(function(details) {
        window.location.href = "index.php?page=Checkout_Capture&token=" + data.orderID;
      });
    },
    onError: function(err) {
      console.error(err);
      alert("Error al procesar el pago con PayPal.");
    }
  }).render("#paypal-button-container");
</script>
