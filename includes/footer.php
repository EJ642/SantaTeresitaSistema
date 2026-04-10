</div> </div> </div> 
     <script src="<?php echo $ruta; ?>bt/bootstrap.min.js"></script>
     <script src="<?php echo $ruta; ?>bt/bootstrap.bundle.min.js"></script>
     <script src="<?php echo $ruta; ?>alertify/alertify.min.js"></script>

     <script>
          const menusitemDropDown = document.querySelectorAll('.menu-item-dropdown');
          const menusItemStatic = document.querySelectorAll('.menu-item-static');
          const menuBtn = document.getElementById('menu-btn');
          const exitBtn = document.getElementById('exit-btn');
          const sidebar = document.getElementById('sidebar');

          menuBtn.addEventListener('click', () => {
               sidebar.classList.toggle('minimize');
          });

          exitBtn.addEventListener('click', (e) => {
               e.preventDefault(); // Evita que el enlace actúe normal (ir al #)

               alertify.confirm("Cerrar Sesión", "¿Está seguro que desea salir del sistema?",
                    function() {
                         // Si el usuario da OK:
                         window.location.href = "<?php echo $ruta; ?>salir.php";
                    },
                    function() {
                         // Si el usuario da Cancelar:
                         alertify.error('Cancelado');
                    }
               ).set('labels', {ok:'Sí, Salir', cancel:'Cancelar'});

          });


          menusitemDropDown.forEach((menuItem) => {
          menuItem.addEventListener('click', () => {
               const subMenu = menuItem.querySelector('.sub-menu');
               const isActive = menuItem.classList.toggle('sub-menu-toggle');
               if (subMenu) {
                    if (isActive) {
                         subMenu.style.height = `${subMenu.scrollHeight + 6}px`;
                         subMenu.style.padding = '0.2rem 0';
                    } else {
                         subMenu.style.height = '0';
                         subMenu.style.padding = '0';
                    }
               }
               menusitemDropDown.forEach((item) => {
                    if (item !== menuItem) {
                         const otherSubmenu = item.querySelector('.sub-menu');
                         if (otherSubmenu) {
                              item.classList.remove('sub-menu-toggle');
                              otherSubmenu.style.height = '0';
                              otherSubmenu.style.padding = '0';
                         }
                    }
               });
          });


          });


          menusItemStatic.forEach((menuItem) => {
          menuItem.addEventListener('mouseenter', () => {

               if (!sidebar.classList.contains('minimize'))return;

               menusitemDropDown.forEach((item) => {
                    const otherSubmenu = item.querySelector('.sub-menu');
                    if (otherSubmenu) {
                         item.classList.remove('sub-menu-toggle');
                         otherSubmenu.style.height = '0';
                         otherSubmenu.style.padding = '0';
                    }
               });

          });
          });
     </script>

</body>
</html>