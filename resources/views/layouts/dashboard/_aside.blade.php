<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel" style="height: 60px">
            <div class="pull-left image">
                <img src="{{ auth()->user()->image_path }}" class="img-circle" style="height: auto;width: auto"
                     alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ auth()->user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">

            <li><a href="{{ route('home') }}"><i class="fa fa-th"></i><span>Dashboard</span></a></li>
            <li><a href="{{ route('categories.index') }}"><i class="fa fa-th"></i><span>Categories</span></a></li>
            <li><a href="{{ route('products.index') }}"><i class="fa fa-th"></i><span>Products</span></a></li>
            <li><a href="{{ route('customers.index') }}"><i class="fa fa-th"></i><span>Customers</span></a></li>
            <li><a href="{{ route('orders.index') }}"><i class="fa fa-th"></i><span>Orders</span></a></li>


        </ul>

    </section>

</aside>

