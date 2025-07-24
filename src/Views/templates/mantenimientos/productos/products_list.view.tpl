<h1>Products List</h1>
<section class="WWList">
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Código</th>
                <th>Producto</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Estado</th>
                <th>
                    <a href="index.php?page=Mantenimientos_Productos_ProductsForm&mode=INS">Add</a>
                </th>
            </tr>
        </thead>
        <tbody>
            {{foreach rows}}
            <tr>
                <td><img src="{{productImgUrl}}" style="width:128px;height:128px;object-fit:cover;"/></td>
                <td>{{productId}}</td>
                <td>{{productName}}</td>
                <td>{{productDescription}}</td>
                <td>{{productPrice}}</td>
                <td>{{productStock}}</td>
                <td>{{productStatus}}</td>
                <td>
                    <a href="index.php?page=Mantenimientos_Productos_ProductsForm&mode=DSP&productId={{productId}}">View</a>&nbsp;
                    <a href="index.php?page=Mantenimientos_Productos_ProductsForm&mode=UPD&productId={{productId}}">Update</a>&nbsp;
                    <a href="index.php?page=Mantenimientos_Productos_ProductsForm&mode=DEL&productId={{productId}}">Delete</a>
                </td>
            </tr>
            {{endfor rows}}
        </tbody>
    </table>
</section>