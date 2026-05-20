import { createContext, useContext, useState, useEffect, useCallback } from 'react'
import { authAPI } from '../api/axios'
import toast from 'react-hot-toast'

// ── Context creation ─────────────────────────────────────────────────────────
const AuthContext = createContext(null)

// ── Provider ─────────────────────────────────────────────────────────────────
export function AuthProvider({ children }) {
  const [user, setUser]       = useState(null)
  const [token, setToken]     = useState(localStorage.getItem('pgrkam_token'))
  const [loading, setLoading] = useState(true)

  // Restore user from localStorage on mount
  useEffect(() => {
    const storedUser = localStorage.getItem('pgrkam_user')
    if (storedUser && token) {
      try {
        setUser(JSON.parse(storedUser))
      } catch {
        localStorage.removeItem('pgrkam_user')
      }
    }
    setLoading(false)
  }, [token])

  // ── Login ──────────────────────────────────────────────────────────────────
  const login = useCallback(async (credentials) => {
    try {
      const { data } = await authAPI.login(credentials)
      const { access_token, user: userData } = data
      localStorage.setItem('pgrkam_token', access_token)
      localStorage.setItem('pgrkam_user', JSON.stringify(userData))
      setToken(access_token)
      setUser(userData)
      toast.success(`Welcome back, ${userData.name}!`)
      return { success: true, user: userData }
    } catch (error) {
      const message = error.response?.data?.message || 'Invalid credentials'
      toast.error(message)
      return { success: false, message }
    }
  }, [])

  // ── Register ───────────────────────────────────────────────────────────────
  const register = useCallback(async (formData) => {
    try {
      const { data } = await authAPI.register(formData)
      const { access_token, user: userData } = data
      localStorage.setItem('pgrkam_token', access_token)
      localStorage.setItem('pgrkam_user', JSON.stringify(userData))
      setToken(access_token)
      setUser(userData)
      toast.success('Account created successfully!')
      return { success: true, user: userData }
    } catch (error) {
      const message = error.response?.data?.message || 'Registration failed'
      const errors  = error.response?.data?.errors  || {}
      toast.error(message)
      return { success: false, message, errors }
    }
  }, [])

  // ── Logout ─────────────────────────────────────────────────────────────────
  const logout = useCallback(async () => {
    try {
      await authAPI.logout()
    } catch {
      // Silently fail – still clear local state
    } finally {
      localStorage.removeItem('pgrkam_token')
      localStorage.removeItem('pgrkam_user')
      setToken(null)
      setUser(null)
      toast.success('Logged out successfully')
    }
  }, [])

  // ── Update cached user ─────────────────────────────────────────────────────
  const updateUser = useCallback((updatedUser) => {
    setUser(updatedUser)
    localStorage.setItem('pgrkam_user', JSON.stringify(updatedUser))
  }, [])

  const isAuthenticated = Boolean(token && user)
  const isAdmin         = user?.role === 'admin'

  return (
    <AuthContext.Provider value={{
      user,
      token,
      loading,
      isAuthenticated,
      isAdmin,
      login,
      register,
      logout,
      updateUser,
    }}>
      {children}
    </AuthContext.Provider>
  )
}

// ── Custom hook ───────────────────────────────────────────────────────────────
export function useAuth() {
  const ctx = useContext(AuthContext)
  if (!ctx) throw new Error('useAuth must be used inside AuthProvider')
  return ctx
}

export default AuthContext
