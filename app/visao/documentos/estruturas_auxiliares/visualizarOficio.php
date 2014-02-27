

<div class="btn-group visualizar-oficio">
        <button class="btn btn-todos active" value="todos" >Todos</button>
        <button class="btn btn-validos" value="validos">Válidos</button>
        <button class="btn btn-invalidos" value="invalidos">Inválidos</button>
        <button class="btn btn-em-aberto" value="aberto">Em Aberto</button>
    </div>
    <script>
        $(document).ready(function(){
           $('.visualizar-oficio .btn-todos').on('click',function(){
               if(!$('.visualizar-oficio .btn-todos').hasClass('active')){
                   $('.visualizar-oficio .btn-todos').addClass('active');
               }
               $('.visualizar-oficio .btn-validos').removeClass('active');
               $('.visualizar-oficio .btn-invalidos').removeClass('active');
               $('.visualizar-oficio .btn-em-aberto').removeClass('active');
               $('.visualizar-oficio').change();
           });
           $('.visualizar-oficio .btn-validos').on('click',function(){
               if(!$('.visualizar-oficio .btn-validos').hasClass('active')){
                   $('.visualizar-oficio .btn-validos').addClass('active');
               }
               $('.visualizar-oficio .btn-todos').removeClass('active');
               $('.visualizar-oficio .btn-invalidos').removeClass('active');
               $('.visualizar-oficio .btn-em-aberto').removeClass('active');
               $('.visualizar-oficio').change();
           });
           $('.visualizar-oficio .btn-invalidos').on('click',function(){
               if(!$('.visualizar-oficio .btn-invalidos').hasClass('active')){
                   $('.visualizar-oficio .btn-invalidos').addClass('active');
               }
               $('.visualizar-oficio .btn-validos').removeClass('active');
               $('.visualizar-oficio .btn-todos').removeClass('active');
               $('.visualizar-oficio .btn-em-aberto').removeClass('active');
               $('.visualizar-oficio').change();
           });
           $('.visualizar-oficio .btn-em-aberto').on('click',function(){
               if(!$('.visualizar-oficio .btn-em-aberto').hasClass('active')){
                   $('.visualizar-oficio .btn-em-aberto').addClass('active');
               }
               $('.visualizar-oficio .btn-validos').removeClass('active');
               $('.visualizar-oficio .btn-invalidos').removeClass('active');
               $('.visualizar-oficio .btn-todos').removeClass('active');
               $('.visualizar-oficio').change();
           });
        });
    </script>
</div>
