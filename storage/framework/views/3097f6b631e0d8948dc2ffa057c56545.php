

<?php echo $__env->make('layouts.header_cliente', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<style>

.main{
    background-image:
    linear-gradient(
        rgba(255,255,255,.75),
        rgba(255,255,255,.75)
    ),
    url('<?php echo e(asset('assets/fondo1.webp')); ?>');

    background-size:cover;
    min-height:100vh;
    flex:1;
    padding:25px;
}

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
    gap:20px;
}

.topbar h1{
    color:#4b2ad6;
    font-size:28px;
    margin:0;
}

.search-box{
    position:relative;
}

.search-box input{
    padding:12px 45px 12px 15px;
    border:1px solid #ddd;
    border-radius:30px;
    width:280px;
    background:#fff;
    outline:none;
}

.search-box i{
    position:absolute;
    right:15px;
    top:13px;
    color:#888;
}

.panel{
    background:#ffffffdd;
    padding:25px;
    border-radius:18px;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
    overflow:auto;
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    text-align:left;
    padding:16px 12px;
    color:#777;
    font-size:13px;
    border-bottom:2px solid #eee;
}

td{
    padding:18px 12px;
    border-bottom:1px solid #f1f1f1;
    font-size:14px;
    color:#333;
}

tr:hover{
    background:#fafafa;
}

.badge{
    padding:8px 14px;
    border-radius:30px;
    font-size:12px;
    font-weight:bold;
    display:inline-flex;
    align-items:center;
    gap:8px;
}

.badge-success{
    background:#e8f8ef;
    color:#27ae60;
}

.badge-warning{
    background:#fff5df;
    color:#f39c12;
}

.badge-danger{
    background:#ffeaea;
    color:#e74c3c;
}

.badge-info{
    background:#ece8ff;
    color:#6c3ce9;
}

.dot{
    width:8px;
    height:8px;
    border-radius:50%;
    background:currentColor;
}

.price{
    font-weight:bold;
    color:#6c3ce9;
}

.btn-detail{
    background:#6c3ce9;
    color:#fff;
    padding:10px 14px;
    border-radius:10px;
    text-decoration:none;
    font-size:13px;
    transition:.2s;
}

.btn-detail:hover{
    opacity:.9;
}

.pagination{
    display:flex;
    justify-content:center;
    margin-top:25px;
}

.pagination nav{
    display:flex;
    gap:8px;
}

.pagination span,
.pagination a{
    min-width:38px;
    height:38px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:10px;
    text-decoration:none;
    font-size:14px;
    border:1px solid #e5e5e5;
    background:#fff;
    color:#555;
}

.pagination .active span{
    background:#6c3ce9;
    color:#fff;
    border-color:#6c3ce9;
}

.empty{
    text-align:center;
    padding:50px 20px;
    color:#777;
}

@media(max-width:900px){

    .topbar{
        flex-direction:column;
        align-items:flex-start;
    }

    .search-box{
        width:100%;
    }

    .search-box input{
        width:100%;
    }

}

</style>

<div class="main">

    <div class="topbar">

        <h1>
            Mis Órdenes
        </h1>

        <div class="search-box">

            <input
                type="text"
                id="searchInput"
                placeholder="Buscar envío..."
            >

            <i class="fa fa-search"></i>

        </div>

    </div>

    <div class="panel">

        <table id="tablaOrdenes">

            <thead>

                <tr>

                    <th># ENVÍO</th>

                    <th>ORIGEN</th>

                    <th>DESTINO</th>

                    <th>ESTADO</th>

                    <th>FECHA</th>

                    <th>TOTAL</th>

                    <th>ACCIONES</th>

                </tr>

            </thead>

            <tbody>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $ordenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orden): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>

                    <?php

                        $ultimoTracking =
                            $orden->tracking->last();

                        $estado =
                            $ultimoTracking->estadoRelacion->nombre
                            ?? 'Pendiente';

                        $badge = 'badge-info';

                        if(
                            str_contains(
                                strtolower($estado),
                                'entregado'
                            )
                        ){
                            $badge = 'badge-success';
                        }

                        if(
                            str_contains(
                                strtolower($estado),
                                'cancel'
                            )
                        ){
                            $badge = 'badge-danger';
                        }

                        if(
                            str_contains(
                                strtolower($estado),
                                'transito'
                            )
                        ){
                            $badge = 'badge-warning';
                        }

                        $total =
                            $orden->costos->sum('monto');

                    ?>

                    <tr>

                        <td>
                            <strong>
                                #<?php echo e($orden->id_envio); ?>

                            </strong>
                        </td>

                        <td>
                            <?php echo e($orden->zonaOrigen->nombre_zona ?? '-'); ?>

                        </td>

                        <td>
                            <?php echo e($orden->zonaDestino->nombre_zona ?? '-'); ?>

                        </td>

                        <td>

                            <span class="badge <?php echo e($badge); ?>">

                                <span class="dot"></span>

                                <?php echo e($estado); ?>


                            </span>

                        </td>

                        <td>
                            <?php echo e(\Carbon\Carbon::parse($orden->fecha_envio)->format('d/m/Y')); ?>

                        </td>

                        <td class="price">

                            S/
                            <?php echo e(number_format($total,2)); ?>


                        </td>

                        <td>

                            <a
                                href="<?php echo e(route('detalle_orden.show',$orden->id_envio)); ?>"
                                class="btn-detail"
                            >
                                Ver detalle
                            </a>

                        </td>

                    </tr>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                    <tr>

                        <td colspan="7">

                            <div class="empty">

                                <i
                                    class="fa fa-box"
                                    style="font-size:40px;margin-bottom:15px;"
                                ></i>

                                <br>

                                No tienes órdenes registradas

                            </div>

                        </td>

                    </tr>

                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            </tbody>

        </table>

        <div class="pagination">

            <?php echo e($ordenes->links()); ?>


        </div>

    </div>

</div>

<script>

document.getElementById('searchInput')
.addEventListener('keyup', function(){

    let filtro =
        this.value.toLowerCase();

    let filas =
        document.querySelectorAll(
            '#tablaOrdenes tbody tr'
        );

    filas.forEach(fila => {

        let texto =
            fila.innerText.toLowerCase();

        fila.style.display =
            texto.includes(filtro)
            ? ''
            : 'none';

    });

});

</script>

</body>
</html><?php /**PATH D:\xampp\htdocs\integrador\resources\views/cliente/envios_cliente.blade.php ENDPATH**/ ?>