<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar sidebar-scroll">
        <div class="main-sidebar-header active">
            <a class="desktop-logo logo-light active" href="#"><img src="images/logo/banner.png" class="main-logo" alt="logo"></a>
            <!-- <a class="desktop-logo logo-dark active" href="index.html"><img src="../../assets/img/brand/logo-white.png" class="main-logo dark-theme" alt="logo"></a> -->
            <a class="logo-icon mobile-logo icon-light active" href="#"><img src="images/logo/logo.png" class="logo-icon" alt="logo"></a>
            <!-- <a class="logo-icon mobile-logo icon-dark active" href="index.html"><img src="../../assets/img/brand/favicon-white.png" class="logo-icon dark-theme" alt="logo"></a> -->
        </div>
        <div class="main-sidemenu">
            <div class="app-sidebar__user clearfix">
                <div class="dropdown user-pro-body">
                    <div class="">
                        <img alt="user-img" class="avatar avatar-xl brround" src="{{ Auth::user()->image ? Auth::user()->image :'/images/profile/profile6.png' }}"><span class="avatar-status profile-status bg-green"></span>
                    </div>
                    <div class="user-info">
                        <h4 class="font-weight-semibold mt-3 mb-0">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h4>
                        <!-- <span class="mb-0 text-muted">Premium Member</span> -->
                    </div>
                </div>
            </div>
            <ul class="side-menu">
                @can('dashboard-view')
                <li class="side-item side-item-category">Main</li>
                <li class="slide">
                    <router-link class="side-menu__item" to="/dashboard">
                        <svg  class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg>
                        <span class="side-menu__label mt-1">Dashboard</span><span class="badge badge-success side-badge">1</span>
                    </router-link>
                </li>
                <!-- <li class="side-item side-item-category">WEB APPS</li>
                <li class="slide">
                    <router-link class="side-menu__item" data-toggle="slide" to="/category"><svg  class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M4 12c0 4.08 3.06 7.44 7 7.93V4.07C7.05 4.56 4 7.92 4 12z" opacity=".3"/><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.94-.49-7-3.85-7-7.93s3.05-7.44 7-7.93v15.86zm2-15.86c1.03.13 2 .45 2.87.93H13v-.93zM13 7h5.24c.25.31.48.65.68 1H13V7zm0 3h6.74c.08.33.15.66.19 1H13v-1zm0 9.93V19h2.87c-.87.48-1.84.8-2.87.93zM18.24 17H13v-1h5.92c-.2.35-.43.69-.68 1zm1.5-3H13v-1h6.93c-.04.34-.11.67-.19 1z"/>
                        </svg><span class="side-menu__label mt-1">Category</span><i class="angle fe fe-chevron-down"></i>
                    </router-link>
                    <ul class="slide-menu">
                        <li><a class=" side-menu-label1">Apps</a></li>
                        <li><a class="slide-item" href="cards.html">Cards</a></li>
                        <li><a class="slide-item" href="darggablecards.html">Darggablecards</a></li>
                        <li><a class="slide-item" href="rangeslider.html">Range-slider</a></li>
                        <li><a class="slide-item" href="calendar.html">Calendar</a></li>
                        <li><a class="slide-item" href="contacts.html">Contacts</a></li>
                        <li><a class="slide-item" href="image-compare.html">Image-compare</a></li>
                        <li><a class="slide-item" href="notification.html">Notification</a></li>
                        <li><a class="slide-item" href="widget-notification.html">Widget-notification</a></li>
                        <li><a class="slide-item" href="treeview.html">Treeview</a></li>
                    </ul>
                </li> -->
                @endcan
                <li class="side-item side-item-category">General</li>
                @can('category-view')
                <li class="slide">
                    <router-link class="side-menu__item" data-toggle="slide" to="/category">
                        <svg  class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M4 12c0 4.08 3.06 7.44 7 7.93V4.07C7.05 4.56 4 7.92 4 12z" opacity=".3"/><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.94-.49-7-3.85-7-7.93s3.05-7.44 7-7.93v15.86zm2-15.86c1.03.13 2 .45 2.87.93H13v-.93zM13 7h5.24c.25.31.48.65.68 1H13V7zm0 3h6.74c.08.33.15.66.19 1H13v-1zm0 9.93V19h2.87c-.87.48-1.84.8-2.87.93zM18.24 17H13v-1h5.92c-.2.35-.43.69-.68 1zm1.5-3H13v-1h6.93c-.04.34-.11.67-.19 1z"/>
                        </svg><span class="side-menu__label mt-1">Category</span><i class="angle fe fe-chevron-down"></i>
                    </router-link>
                    <!-- <ul class="slide-menu">
                        <li><a class=" side-menu-label1">Products</a></li>
                        <li><a class="slide-item" href="products.html">Products</a></li>
                        <li><a class="slide-item" href="product-details.html">Product-Details</a></li>
                        <li><a class="slide-item" href="product-cart.html">Cart</a></li>
                    </ul> -->
                </li>
                @endcan
                @can('product-view', 'product-component-view', 'ingredient-view')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <svg  class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M3.31 11l2.2 8.01L18.5 19l2.2-8H3.31zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z" opacity=".3"/><path d="M22 9h-4.79l-4.38-6.56c-.19-.28-.51-.42-.83-.42s-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1zM12 4.8L14.8 9H9.2L12 4.8zM18.5 19l-12.99.01L3.31 11H20.7l-2.2 8zM12 13c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                        <span class="side-menu__label mt-1">Products</span><i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a class=" side-menu-label1">Products</a></li>
                        @can('product-view')
                        <li><router-link class="slide-item" to="/product">Product List</router-link></li>
                        @endcan
                        @can('product-component-view')
                        <li><router-link class="slide-item" to="/product-component">Product Component</router-link></li>
                        @endcan
                        @can('ingredient-view')
                        <li><router-link class="slide-item" to="/ingredients">Ingredients</router-link></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('order-view')
                <li class="slide">
                    <router-link class="side-menu__item" data-toggle="slide" to="/order">
                    <svg  class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h15v3H5zm12 5h3v9h-3zm-7 0h5v9h-5zm-5 0h3v9H5z" opacity=".3"/><path d="M20 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h15c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM8 19H5v-9h3v9zm7 0h-5v-9h5v9zm5 0h-3v-9h3v9zm0-11H5V5h15v3z"/></svg>
                        <span class="side-menu__label mt-1">Orders</span><i class="angle fe fe-chevron-down"></i>
                    </router-link>
                </li>
                @endcan
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <svg  enable-background="new 0 0 24 24" class="side-menu__icon" viewBox="0 0 24 24" ><g><rect fill="none"/></g><g><g/><g><path d="M21,5c-1.11-0.35-2.33-0.5-3.5-0.5c-1.95,0-4.05,0.4-5.5,1.5c-1.45-1.1-3.55-1.5-5.5-1.5S2.45,4.9,1,6v14.65 c0,0.25,0.25,0.5,0.5,0.5c0.1,0,0.15-0.05,0.25-0.05C3.1,20.45,5.05,20,6.5,20c1.95,0,4.05,0.4,5.5,1.5c1.35-0.85,3.8-1.5,5.5-1.5 c1.65,0,3.35,0.3,4.75,1.05c0.1,0.05,0.15,0.05,0.25,0.05c0.25,0,0.5-0.25,0.5-0.5V6C22.4,5.55,21.75,5.25,21,5z M3,18.5V7 c1.1-0.35,2.3-0.5,3.5-0.5c1.34,0,3.13,0.41,4.5,0.99v11.5C9.63,18.41,7.84,18,6.5,18C5.3,18,4.1,18.15,3,18.5z M21,18.5 c-1.1-0.35-2.3-0.5-3.5-0.5c-1.34,0-3.13,0.41-4.5,0.99V7.49c1.37-0.59,3.16-0.99,4.5-0.99c1.2,0,2.4,0.15,3.5,0.5V18.5z"/><path d="M11,7.49C9.63,6.91,7.84,6.5,6.5,6.5C5.3,6.5,4.1,6.65,3,7v11.5C4.1,18.15,5.3,18,6.5,18 c1.34,0,3.13,0.41,4.5,0.99V7.49z" opacity=".3"/></g><g><path d="M17.5,10.5c0.88,0,1.73,0.09,2.5,0.26V9.24C19.21,9.09,18.36,9,17.5,9c-1.28,0-2.46,0.16-3.5,0.47v1.57 C14.99,10.69,16.18,10.5,17.5,10.5z"/><path d="M17.5,13.16c0.88,0,1.73,0.09,2.5,0.26V11.9c-0.79-0.15-1.64-0.24-2.5-0.24c-1.28,0-2.46,0.16-3.5,0.47v1.57 C14.99,13.36,16.18,13.16,17.5,13.16z"/><path d="M17.5,15.83c0.88,0,1.73,0.09,2.5,0.26v-1.52c-0.79-0.15-1.64-0.24-2.5-0.24c-1.28,0-2.46,0.16-3.5,0.47v1.57 C14.99,16.02,16.18,15.83,17.5,15.83z"/></g></g></svg>
                        <span class="side-menu__label mt-1">Sales</span><i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a class=" side-menu-label1">Sales</a></li>
                        @can('sales-view')
                        <li><router-link class="slide-item" to="/sales-pos">Sales POS</router-link></li>
                        @endcan
                        @can('ordering-view')
                        <li><router-link class="slide-item" to="/orders-pos">Orders POS</router-link></li>
                        @endcan
                        <li><a class="slide-item" href="/queue" target="_blank">Queue</a></li>
                    </ul>
                </li>
                @can('inventory-view')
                <li class="slide">
                    <router-link class="side-menu__item" data-toggle="slide" to="/inventory">
                        <svg  class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3"/><path d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/></svg>
                        <span class="side-menu__label mt-1">Inventories</span>
                    </router-link>
                    <!-- <ul class="slide-menu">
                        <li><a class=" side-menu-label1">Inventories</a></li>
                        <li><a class="slide-item" href="chart-morris.html">Morris Charts</a></li>
                        <li><a class="slide-item" href="chart-flot.html">Flot Charts</a></li>
                        <li><a class="slide-item" href="chart-chartjs.html">ChartJS</a></li>
                        <li><a class="slide-item" href="chart-echart.html">Echart</a></li>
                        <li><a class="slide-item" href="chart-sparkline.html">Sparkline</a></li>
                        <li><a class="slide-item" href="chart-peity.html">Chart-peity</a></li>
                    </ul> -->
                </li>
                @endcan
                
                @can('user-management-view', 'role-view', 'permission-view')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <svg  class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M6.26 9L12 13.47 17.74 9 12 4.53z" opacity=".3"/><path d="M19.37 12.8l-7.38 5.74-7.37-5.73L3 14.07l9 7 9-7zM12 2L3 9l1.63 1.27L12 16l7.36-5.73L21 9l-9-7zm0 11.47L6.26 9 12 4.53 17.74 9 12 13.47z"/></svg>
                        <span class="side-menu__label mt-1">Management</span><i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a class=" side-menu-label1">Management</a></li>
                        @can('user-management-view')
                        <li><router-link class="slide-item" to="/user-management">User Management</router-link></li>
                        @endcan
                        @can('role-view')
                        <li><router-link class="slide-item" to="/roles">Roles</router-link></li>
                        @endcan
                        <!-- @can('permission-view')
                        <li><router-link class="slide-item" to="/permissions">Permissions </router-link></li>
                        @endcan -->
                    </ul>
                </li>
                @endcan
                @can('attendance-view', 'employee-list-view', 'payroll-view')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <svg  class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M13 4H6v16h12V9h-5V4zm3 14H8v-2h8v2zm0-6v2H8v-2h8z" opacity=".3"></path><path d="M8 16h8v2H8zm0-4h8v2H8zm6-10H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"></path></svg>
                        <span class="side-menu__label mt-1">Employee</span><i class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        <li><a class="side-menu-label1">Employee</a></li>
                        @can('employee-list-view')
                        <li><router-link class="slide-item" to="/employee">Employee List</router-link></li>
                        @endcan
                        @can('attendance-view')
                        <li><router-link class="slide-item" to="/attendance">Attendance</router-link></li>
                        @endcan
                        @can('payroll-view')
                        <li><router-link class="slide-item" to="/payroll">Payroll</router-link></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                <li class="slide">
                    <router-link class="side-menu__item" data-toggle="slide" to="/settings">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M10.9 19.91c.36.05.72.09 1.1.09 2.18 0 4.16-.88 5.61-2.3L14.89 13l-3.99 6.91zm-1.04-.21l2.71-4.7H4.59c.93 2.28 2.87 4.03 5.27 4.7zM8.54 12L5.7 7.09C4.64 8.45 4 10.15 4 12c0 .69.1 1.36.26 2h5.43l-1.15-2zm9.76 4.91C19.36 15.55 20 13.85 20 12c0-.69-.1-1.36-.26-2h-5.43l3.99 6.91zM13.73 9h5.68c-.93-2.28-2.88-4.04-5.28-4.7L11.42 9h2.31zm-3.46 0l2.83-4.92C12.74 4.03 12.37 4 12 4c-2.18 0-4.16.88-5.6 2.3L9.12 11l1.15-2z" opacity=".3"></path><path d="M12 22c5.52 0 10-4.48 10-10 0-4.75-3.31-8.72-7.75-9.74l-.08-.04-.01.02C13.46 2.09 12.74 2 12 2 6.48 2 2 6.48 2 12s4.48 10 10 10zm0-2c-.38 0-.74-.04-1.1-.09L14.89 13l2.72 4.7C16.16 19.12 14.18 20 12 20zm8-8c0 1.85-.64 3.55-1.7 4.91l-4-6.91h5.43c.17.64.27 1.31.27 2zm-.59-3h-7.99l2.71-4.7c2.4.66 4.35 2.42 5.28 4.7zM12 4c.37 0 .74.03 1.1.08L10.27 9l-1.15 2L6.4 6.3C7.84 4.88 9.82 4 12 4zm-8 8c0-1.85.64-3.55 1.7-4.91L8.54 12l1.15 2H4.26C4.1 13.36 4 12.69 4 12zm6.27 3h2.3l-2.71 4.7c-2.4-.67-4.35-2.42-5.28-4.7h5.69z"></path></svg>
                        <span class="side-menu__label mt-1">Settings</span><i class="angle fe fe-chevron-down"></i>
                    </router-link>
                </li>
                <!-- <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#"><svg  class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0z" fill="none"/><path d="M12 4c-4.41 0-8 3.59-8 8s3.59 8 8 8c.28 0 .5-.22.5-.5 0-.16-.08-.28-.14-.35-.41-.46-.63-1.05-.63-1.65 0-1.38 1.12-2.5 2.5-2.5H16c2.21 0 4-1.79 4-4 0-3.86-3.59-7-8-7zm-5.5 9c-.83 0-1.5-.67-1.5-1.5S5.67 10 6.5 10s1.5.67 1.5 1.5S7.33 13 6.5 13zm3-4C8.67 9 8 8.33 8 7.5S8.67 6 9.5 6s1.5.67 1.5 1.5S10.33 9 9.5 9zm5 0c-.83 0-1.5-.67-1.5-1.5S13.67 6 14.5 6s1.5.67 1.5 1.5S15.33 9 14.5 9zm4.5 2.5c0 .83-.67 1.5-1.5 1.5s-1.5-.67-1.5-1.5.67-1.5 1.5-1.5 1.5.67 1.5 1.5z" opacity=".3"/><path d="M12 2C6.49 2 2 6.49 2 12s4.49 10 10 10c1.38 0 2.5-1.12 2.5-2.5 0-.61-.23-1.21-.64-1.67-.08-.09-.13-.21-.13-.33 0-.28.22-.5.5-.5H16c3.31 0 6-2.69 6-6 0-4.96-4.49-9-10-9zm4 13h-1.77c-1.38 0-2.5 1.12-2.5 2.5 0 .61.22 1.19.63 1.65.06.07.14.19.14.35 0 .28-.22.5-.5.5-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.14 8 7c0 2.21-1.79 4-4 4z"/><circle cx="6.5" cy="11.5" r="1.5"/><circle cx="9.5" cy="7.5" r="1.5"/><circle cx="14.5" cy="7.5" r="1.5"/><circle cx="17.5" cy="11.5" r="1.5"/></svg><span class="side-menu__label mt-1">Advanced UI</span><i class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        <li><a class=" side-menu-label1">Advanced UI</a></li>
                        <li><a class="slide-item" href="accordion.html">Accordion</a></li>
                        <li><a class="slide-item" href="carousel.html">Carousel</a></li>
                        <li><a class="slide-item" href="collapse.html">Collapse</a></li>
                        <li><a class="slide-item" href="modals.html">Modals</a></li>
                        <li><a class="slide-item" href="timeline.html">Timeline</a></li>
                        <li><a class="slide-item" href="sweet-alert.html">Sweet Alert</a></li>
                        <li><a class="slide-item" href="rating.html">Ratings</a></li>
                        <li><a class="slide-item" href="counters.html">Counters</a></li>
                        <li><a class="slide-item" href="search.html">Search</a></li>
                        <li><a class="slide-item" href="userlist.html">Userlist</a></li>
                        <li><a class="slide-item" href="blog.html">Blog</a></li>
                    </ul>
                </li> -->
                
            </ul>
        </div>
    </aside>
    <!-- main-sidebar -->