import { Navigate, Outlet } from 'react-router-dom'
import { useAuth } from '../context/AuthContext'
import Loader from '../components/Loader'

/**
 * ProtectedRoute – redirects unauthenticated users to /login.
 */
export function ProtectedRoute() {
  const { isAuthenticated, loading } = useAuth()
  if (loading) return <Loader fullPage />
  return isAuthenticated ? <Outlet /> : <Navigate to="/login" replace />
}

/**
 * AdminRoute – accessible only by admin users.
 */
export function AdminRoute() {
  const { isAuthenticated, isAdmin, loading } = useAuth()
  if (loading) return <Loader fullPage />
  if (!isAuthenticated) return <Navigate to="/login" replace />
  if (!isAdmin) return <Navigate to="/dashboard" replace />
  return <Outlet />
}

/**
 * GuestRoute – redirects already-authenticated users away from login/register.
 */
export function GuestRoute() {
  const { isAuthenticated, loading } = useAuth()
  if (loading) return <Loader fullPage />
  return isAuthenticated ? <Navigate to="/dashboard" replace /> : <Outlet />
}
