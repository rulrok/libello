<div class="btn-group visualizar-memorando">
        <button class="btn btn-todos active" value="todos" >Todos</button>
        <button class="btn btn-validos" value="validos">Válidos</button>
        <button class="btn btn-invalidos" value="invalidos">Inválidos</button>
        <button class="btn btn-em-aberto" value="aberto">Em Aberto</button>
    </div>
    <script>
        $(document).ready(function(){
           $('.visualizar-memorando .btn-todos').on('click',function(){
               if(!$('.visualizar-memorando .btn-todos').hasClass('active')){
                   $('.visualizar-memorando .btn-todos').addClass('active');
               }
               $('.visualizar-memorando .btn-validos').removeClass('active');
               $('.visualizar-memorando .btn-invalidos').removeClass('active');
               $('.visualizar-memorando .btn-em-aberto').removeClass('active');
               $('.visualizar-memorando ').change();
           });
           $('.visualizar-memorando .btn-validos').on('click',function(){
               if(!$('.visualizar-memorando .btn-validos').hasClass('active')){
                   $('.visualizar-memorando .btn-validos').addClass('active');
               }
               $('.visualizar-memorando .btn-todos').removeClass('active');
               $('.visualizar-memorando .btn-invalidos').removeClass('active');
               $('.visualizar-memorando .btn-em-aberto').removeClass('active');
               $('.visualizar-memorando ').change();
           });
           $('.visualizar-memorando .btn-invalidos').on('click',function(){
               if(!$('.visualizar-memorando .btn-invalidos').hasClass('active')){
                   $('.visualizar-memorando .btn-invalidos').addClass('active');
               }
               $('.visualizar-memorando .btn-validos').removeClass('active');
               $('.visualizar-memorando .btn-todos').removeClass('active');
               $('.visualizar-memorando .btn-em-aberto').removeClass('active');
               $('.visualizar-memorando').change();
           });
           $('.visualizar-memorando .btn-em-aberto').on('click',function(){
               if(!$('.visualizar-memorando .btn-em-aberto').hasClass('active')){
                   $('.visualizar-memorando .btn-em-aberto').addClass('active');
               }
               $('.visualizar-memorando .btn-validos').removeClass('active');
               $('.visualizar-memorando .btn-invalidos').removeClass('active');
               $('.visualizar-memorando .btn-todos').removeClass('active');
               $('.visualizar-memorando').change();
           });
        });
    </script>
</div>
