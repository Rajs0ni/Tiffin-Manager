
const routes = [
  {
    path: '/',
    redirect:'/customer',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { 
        path: 'customer', component: () => import('pages/Customer/Index.vue') ,
        children:
          [
            { path: '', component: () => import('components/Customer/Menu/menu.vue') },
            { path: 'orders', component: () => import('components/Customer/Order/list.vue') },
            { path: 'orders/:id', component: () => import('components/Customer/Order/order.vue') }
          ]
      },
      { 
        path: 'provider', component: () => import('pages/Provider/Index.vue') ,
        children:
          [
            { path: '', component: () => import('components/Provider/Menu/menu.vue') },
            { path: 'orders', component: () => import('components/Provider/Order/list.vue') },
            { path: 'orders/:id', component: () => import('components/Provider/Order/order.vue') }
          ]
      },
    ]
  }
]

// Always leave this as last one
if (process.env.MODE !== 'ssr') {
  routes.push({
    path: '*',
    component: () => import('pages/Error404.vue')
  })
}

export default routes
