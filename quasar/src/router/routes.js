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
            { path: '', component: () => import('components/Customer/Menu/Menu.vue') },
            { path: 'orders', component: () => import('components/Customer/Order/List.vue') },
            { path: 'orders/:id', component: () => import('components/Customer/Order/Order.vue') }
          ],
          meta: { 
            requiresAuth: true
          }
      },
      { 
        path: 'provider', component: () => import('pages/Provider/Index.vue') ,
        children:
          [
            { path: '', component: () => import('components/Provider/Menu/Menu.vue') },
            { path: 'orders', component: () => import('components/Provider/Order/List.vue') },
            { path: 'orders/:id', component: () => import('components/Provider/Order/Order.vue') }
          ]
      },
    ]
  },
  {
    path:'/verify',
    component: () => import('components/VerifyMobile.vue')
  },
  {
    path:'/register',
    component: () => import('components/Register.vue'),
    meta: { 
      requiresAuth: true
    }

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
