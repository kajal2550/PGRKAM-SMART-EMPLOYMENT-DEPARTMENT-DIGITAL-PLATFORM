import axios from 'axios'

// Base Axios instance configured for the Laravel backend
const api = axios.create({
  baseURL: '/api',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
})

// ── Request Interceptor ──────────────────────────────────────────────────────
// Attach the bearer token from localStorage on every request
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('pgrkam_token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error) => Promise.reject(error)
)

// ── Response Interceptor ─────────────────────────────────────────────────────
// Handle 401 Unauthorized – clear auth state and redirect to login
api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem('pgrkam_token')
      localStorage.removeItem('pgrkam_user')
      window.location.href = '/login'
    }
    return Promise.reject(error)
  }
)

// ── Auth API ─────────────────────────────────────────────────────────────────
export const authAPI = {
  login:    (data)  => api.post('/login', data),
  register: (data)  => api.post('/register', data),
  logout:   ()      => api.post('/logout'),
  getUser:  ()      => api.get('/user/profile'),
}

// ── Services API ─────────────────────────────────────────────────────────────
export const servicesAPI = {
  getAll:  ()         => api.get('/services'),
  getById: (id)       => api.get(`/services/${id}`),
  create:  (data)     => api.post('/services', data),
  update:  (id, data) => api.put(`/services/${id}`, data),
  delete:  (id)       => api.delete(`/services/${id}`),
}

// ── Jobs API ─────────────────────────────────────────────────────────────────
export const jobsAPI = {
  getAll:   (params)  => api.get('/jobs', { params }),
  getById:  (id)      => api.get(`/jobs/${id}`),
  create:   (data)    => api.post('/jobs', data),
  update:   (id, data)=> api.put(`/jobs/${id}`, data),
  delete:   (id)      => api.delete(`/jobs/${id}`),
  saveJob:  (id)            => api.post(`/jobs/${id}/save`),
  applyJob: (id, data)      => api.post(`/jobs/${id}/apply`, data),
  getSaved: ()              => api.get('/user/saved-jobs'),
}

// ── Training API ─────────────────────────────────────────────────────────────
export const trainingAPI = {
  getAll:   (params)  => api.get('/training', { params }),
  getById:  (id)      => api.get(`/training/${id}`),
  enroll:   (id, data) => api.post(`/training/${id}/enroll`, data),
}

// ── Chat / Guidance API ──────────────────────────────────────────────────────
export const chatAPI = {
  sendMessage: (message) => api.post('/chat-guide', { message }),
}

// ── User / Profile API ───────────────────────────────────────────────────────
export const userAPI = {
  getProfile:      ()       => api.get('/user/profile'),
  updateProfile:   (data)   => api.put('/user/profile', data),
  changePassword:  (data)   => api.put('/user/password', data),
  getNotifications: ()      => api.get('/user/notifications'),
  markNotifRead:   (id)     => api.put(`/user/notifications/${id}/read`),
  getResume:       ()       => api.get('/user/resume'),
  saveResume:      (data)   => api.post('/user/resume', data),
  getCounselling:  ()       => api.get('/user/counselling'),
  bookCounselling: (data)   => api.post('/counselling', data),
  getApplications: ()       => api.get('/user/applications'),
  getEnrollments:  ()       => api.get('/user/enrollments'),
  unsaveJob:       (id)     => api.delete(`/user/saved-jobs/${id}`),
}

// ── Admin API ────────────────────────────────────────────────────────────────
export const adminAPI = {
  getUsers:    ()         => api.get('/admin/users'),
  deleteUser:  (id)       => api.delete(`/admin/users/${id}`),
  getReports:  ()         => api.get('/admin/reports'),
  getDashboard:()         => api.get('/admin/dashboard'),
  getSchemes:  ()         => api.get('/admin/schemes'),
  addScheme:   (data)     => api.post('/admin/schemes', data),
}

// ── Public Stats ─────────────────────────────────────────────────────────────
export const statsAPI = {
  get: () => api.get('/stats'),
}

export default api
