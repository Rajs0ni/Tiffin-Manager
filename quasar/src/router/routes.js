
const routes = [
  {
    path: '/',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: 'index', component: () => import('pages/Index.vue') ,
      children:[
        { path: 'demo1', component: () => import('components/demo1.vue') },
        { path: 'demo2', component: () => import('components/demo2.vue') }
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
