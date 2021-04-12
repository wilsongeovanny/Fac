
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">
                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                    <img src="<?php echo SERVERURL; ?>cuenta/<?php echo $_SESSION['foto']; ?>" alt=""><?php echo $_SESSION['usuario_gad']; ?>
                                </a>
                                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="javascript:;"><i class="fa fa-user pull-right"></i> Perfil</a>
                                    <!--<a class="dropdown-item" href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>Settings</span>
                                    </a>-->
                                    <a class="dropdown-item" target="_blank" href="https://walink.co/f40491"><i class="fa fa-whatsapp pull-right"></i> Ayuda</a>
                                    <a href="<?php echo trim($_SESSION['token_gad']); ?>" class="dropdown-item btn-exit-system"><i class="fa fa-sign-out pull-right"></i> Salir</a>
                                </div>
                            </li>

                           
                        </ul>
                    </nav>
                </div>
            </div>