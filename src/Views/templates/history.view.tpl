

<style>

  .history-sales {
    padding: 20px;
    background: #fafafa;
  }

  
  .history-sales table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 12px; 
    margin-top: 16px;
  }


  .history-sales th,
  .history-sales td {
    padding: 10px 14px;
    background: #fff;
    vertical-align: top;
  }


  .history-sales th {
    background: #f0f0f0;
    font-weight: 600;
  }


  .history-sales td {
    word-break: break-word;
    max-width: 180px;
     text-align: center;        
  vertical-align: middle; 
  }

 
  .history-sales tr:not(:last-child) td {
    border-bottom: 1px solid #e0e0e0;
  }
</style>

<section class="history-sales">
  <h1>Historial de Compras</h1>

  {{if ventas}}
    <table>
      <thead>
        <tr>
          <th>ID Venta</th>
          <th>Producto</th>
          <th>Precio</th>
          <th>Fecha Inicio</th>
          <th>Fecha Fin</th>
        </tr>
      </thead>
      <tbody>
        {{foreach ventas}}
          <tr>
            <td>{{saleId}}</td>
            <td>{{productName}}</td>
            <td>L.{{salePrice}}</td>
            <td>{{saleStart}}</td>
            <td>{{saleEnd}}</td>
          </tr>
        {{endfor ventas}}
      </tbody>
    </table>
  {{endif ventas}}

  {{if not ventas}}
    <p>No hay ventas registradas.</p>
  {{endif not ventas}}
</section>
