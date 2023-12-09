<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
        <span class="brand-text pl-5 font-weight-bold">Admin Panel </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 pl-4 d-flex">
            <div class="info">
                <a href="#" class="d-block"> <?php echo ''; ?> </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item has-treeview">
                    <a href="index.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview <?php echo in_array('User Directory', $activePages) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?php echo in_array('User Directory', $activePages) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            User Directory
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="users.php" class="nav-link <?php echo in_array('All Users', $activePages) ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p> All Users </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="admins.php" class="nav-link <?php echo in_array('All Admins', $activePages) ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p> All Admins </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview <?php echo in_array('Manage', $activePages) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?php echo in_array('Manage', $activePages) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>
                            Manage
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="wins.php" class="nav-link <?php echo in_array('Winnings', $activePages) ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Winnings </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="strategies.php" class="nav-link <?php echo in_array('Strategies', $activePages) ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Strategies </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview <?php echo in_array('Orders', $activePages) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?php echo in_array('Orders', $activePages) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-sync"></i>
                        <p>
                            Orders
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="orders.php" class="nav-link <?php echo in_array('All Orders', $activePages) ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p> All Orders </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview <?php echo in_array('Payments', $activePages) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?php echo in_array('Payments', $activePages) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-money-check-alt"></i>
                        <p>
                            Payments
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="deposits.php" class="nav-link <?php echo in_array('Deposits', $activePages) ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Deposits  </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="withdrawls.php" class="nav-link <?php echo in_array('Withdrawls', $activePages) ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Withdrawls  </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="vouchers.php" class="nav-link <?php echo in_array('Vouchers', $activePages) ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Vouchers  </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview <?php echo in_array('System', $activePages) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?php echo in_array('System', $activePages) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            System
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="settings.php" class="nav-link <?php echo in_array('Settings', $activePages) ? 'active' : '' ?>">
                                <i class="fas fa-tools nav-icon"></i>
                                <p> Settings  </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="logs.php" class="nav-link <?php echo in_array('Logs', $activePages) ? 'active' : '' ?>">
                                <i class="fas fa-book nav-icon"></i>
                                <p> Logs  </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview <?php echo in_array('Merchants', $activePages) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?php echo in_array('Merchants', $activePages) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Merchants
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="merchants.php" class="nav-link <?php echo in_array('List', $activePages) ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p> All Merchants  </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="add_merchant.php" class="nav-link <?php echo in_array('add_merchant', $activePages) ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Add New  </p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="merchants.php" class="nav-link <?php echo in_array('Transactions', $activePages) ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Transactions  </p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>