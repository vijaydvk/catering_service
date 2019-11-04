    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="<?php echo base_url();?>/assets/images/user.png" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $this->session->userdata('username'); ?></div>
                    <div class="email">john.doe@example.com</div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo base_url();?>/foodcorridor_controller/logout"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu" style="overflow-y:auto;">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li <?php if($this->router->fetch_method() == 'dashboard_view' || $this->router->fetch_method() == 'login' ) echo 'class="active"';?>>
                        <a href="<?php echo base_url();?>/foodcorridor_controller/dashboard_view">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li <?php if($this->router->fetch_method() == 'billing_new' || $this->router->fetch_method() == 'billing_edit' || $this->router->fetch_method() == 'billing_view' || $this->router->fetch_method() == 'billing_initiated') echo 'class="active"';?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">text_fields</i>
                            <span>Billing</span>
                        </a>
						<ul class="ml-menu">
                            <li <?php if($this->router->fetch_method() == 'billing_new') echo 'class="active"';?>>
                                <a href="<?php echo base_url();?>/foodcorridor_controller/billing_new">New Bill</a>
                            </li>
                            <?php if($this->session->userdata('username')=="admin"){ ?>
                            <li <?php if($this->router->fetch_method() == 'billing_edit') echo 'class="active"';?>>
                                <a href="<?php echo base_url();?>/foodcorridor_controller/billing_edit">Edit Bill</a>
                            </li>
                            <?php } ?>
							<li <?php if($this->router->fetch_method() == 'billing_view') echo 'class="active"';?>>
                                <a href="<?php echo base_url();?>/foodcorridor_controller/billing_view">View Bill</a>
                            </li>
                            <?php if($this->session->userdata('username')=="admin"){ ?>
							<li <?php if($this->router->fetch_method() == 'billing_initiated') echo 'class="active"';?>>
                                <a href="<?php echo base_url();?>/foodcorridor_controller/billing_initiated">Initiated Bill</a>
                            </li>
                            <?php } ?>
						</ul>
                    </li>
                    <li <?php if($this->router->fetch_method() == 'customer_report' || $this->router->fetch_method() == 'invoice_report') echo 'class="active"';?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">text_fields</i>
                            <span>Reports</span>
                        </a>
						<ul class="ml-menu">
                            <li <?php if($this->router->fetch_method() == 'customer_report') echo 'class="active"';?>>
                                <a href="<?php echo base_url();?>/foodcorridor_controller/customer_report">Customer Basis</a>
                            </li>
                            <li <?php if($this->router->fetch_method() == 'invoice_report') echo 'class="active"';?>>
                                <a href="<?php echo base_url();?>/foodcorridor_controller/invoice_report">Invoice</a>
                            </li>
						</ul>
                    </li>					
                    <li <?php if($this->router->fetch_method() == 'customer_view') echo 'class="active"';?>>
                        <a href="<?php echo base_url();?>/foodcorridor_controller/customer_view">
                            <i class="material-icons">layers</i>
                            <span>Customers</span>
                        </a>
                    </li>  
                    <?php if($this->session->userdata('username')=="admin"){ ?>
                    <li <?php if($this->router->fetch_method() == 'category_view') echo 'class="active"';?>>
                        <a href="<?php echo base_url();?>/foodcorridor_controller/category_view">
                            <i class="material-icons">list</i>
                            <span>Food Categories</span>
                        </a>
                    </li>
                     <?php } ?>				
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2018 - 2019 <a href="javascript:void(0);">FoodCorridor</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.0
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->        
    </section>


