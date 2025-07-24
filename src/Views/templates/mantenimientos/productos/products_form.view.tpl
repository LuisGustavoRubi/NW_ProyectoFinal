<h1>{{modeDesc}}</h1>
<section class="row">
    <form method="post" action="index.php?page=Mantenimientos_Productos_ProductsForm&mode={{mode}}&productId={{productId}}" class="col-6 offset-3">
        <input type="hidden" name="mode" value="{{mode}}">
        <input type="hidden" name="crf_token" value="{{crf_token}}">
        <input type="hidden" name="productId" value="{{productId}}">
        <div class="row">
            <label class="col-4" for="{{productId}}">Código</label>
            <input class="col-8" type="text" name="productId" id="{{productId}}" value="{{productId}}" {{isReadOnly}}>
        </div>
        <div class="row">
            <label class="col-4" for="{{productName}}">Producto</label>
            <input class="col-8" type="text" name="productName" id="{{productName}}" value="{{productName}}" {{isReadOnly}}>
        </div>
        <div class="row">
            <label class="col-4" for="{{productDescription}}">Description</label>
            <input class="col-8" type="text" name="productDescription" id="{{productDescription}}" value="{{productDescription}}"
                {{isReadOnly}}>
        </div>
        <div class="row">
            <label class="col-4" for="{{productPrice}}">Precio</label>
            <input class="col-8" type="text" name="productPrice" id="{{productPrice}}" value="{{productPrice}}" {{isReadOnly}}>
        </div>
        <div class="row">
            <label class="col-4" for="{{productImgUrl}}">Url Imágen</label>
            <input class="col-8" type="text" name="productImgUrl" id="{{productImgUrl}}" value="{{productImgUrl}}" {{isReadOnly}}>
        </div>
        <div class="row">
            <label class="col-4" for="{{productStock}}">Stock</label>
            <input class="col-8" type="text" name="productStock" id="{{productStock}}" value="{{productStock}}" {{isReadOnly}}>
        </div>
        <div class="row">
            <label class="col-4" for="{{productStatus}}">Estado</label>
            <input class="col-8" type="text" name="productStatus" id="{{productStatus}}" value="{{productStatus}}" {{isReadOnly}}>
        </div>
        <div class="row right">
            <input type="submit" value="Save" {{isReadOnly}}>
            &nbsp;
            <button><a href="index.php?page=Mantenimientos_Productos_Products">Cancel</a></button>
        </div>
    </form>
</section>