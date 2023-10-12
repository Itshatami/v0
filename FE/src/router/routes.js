const routes = [
  {
    path: "/",
    component: () => import("layouts/MainLayout.vue"),
    children: [
      {
        path: "",
        component: () => import("pages/DashboardPage.vue"),
        meta: {
          requireAuth: true,
        },
      },
    ],
  },
  {
    path: "/register",
    component: () => import("layouts/StarterLayout.vue"),
    children: [
      {
        path: "",
        component: () => import("pages/auth/RegisterPage.vue"),
        meta: {
          requireAuth: false,
          register: true,
        },
      },
    ],
  },
  {
    path: "/login",
    component: () => import("layouts/StarterLayout.vue"),
    children: [
      {
        path: "",
        component: () => import("pages/auth/Login-Page.vue"),
        meta: {
          requireAuth: false,
          login: true,
        },
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: "/:catchAll(.*)*",
    component: () => import("pages/ErrorNotFound.vue"),
  },
];

export default routes;
