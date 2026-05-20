import { useState } from 'react'
import { Link, useNavigate } from 'react-router-dom'
import { useAuth } from '../context/AuthContext'
import { FiMail, FiLock, FiEye, FiEyeOff, FiLogIn } from 'react-icons/fi'
import { MdWork } from 'react-icons/md'
import Loader from '../components/Loader'

export default function Login() {
  const { login }      = useAuth()
  const navigate       = useNavigate()
  const [form, setForm]    = useState({ email: '', password: '' })
  const [errors, setErrors]= useState({})
  const [loading, setLoading] = useState(false)
  const [showPw, setShowPw]   = useState(false)

  const validate = () => {
    const e = {}
    if (!form.email)    e.email    = 'Email is required'
    if (!form.password) e.password = 'Password is required'
    return e
  }

  const handleSubmit = async (e) => {
    e.preventDefault()
    const errs = validate()
    if (Object.keys(errs).length) { setErrors(errs); return }
    setLoading(true)
    const result = await login(form)
    setLoading(false)
    if (result.success) {
      navigate(result.user?.role === 'admin' ? '/admin' : '/dashboard')
    }
  }

  return (
    <div className="min-h-screen flex">
      {/* Left panel */}
      <div className="hidden lg:flex lg:w-1/2 bg-gradient-primary flex-col justify-between p-12">
        <Link to="/" className="flex items-center gap-3">
          <div className="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
            <MdWork className="text-white" size={22} />
          </div>
          <span className="text-white font-bold text-xl">PGRKAM</span>
        </Link>

        <div>
          <h2 className="text-4xl font-extrabold text-white mb-4">
            Welcome back to<br />Punjab's #1<br />Employment Portal
          </h2>
          <p className="text-white/70 max-w-sm">
            Access thousands of government and private jobs, skill training programs,
            and career guidance — all in one place.
          </p>
        </div>

        <p className="text-white/40 text-sm">
          © {new Date().getFullYear()} PGRKAM – Government of Punjab
        </p>
      </div>

      {/* Right panel – form */}
      <div className="flex-1 flex items-center justify-center p-6 bg-gray-50">
        <div className="w-full max-w-md">
          {/* Mobile logo */}
          <Link to="/" className="lg:hidden flex items-center gap-2 mb-8">
            <div className="w-9 h-9 bg-primary-600 rounded-xl flex items-center justify-center">
              <MdWork className="text-white" size={20} />
            </div>
            <span className="font-bold text-primary-800">PGRKAM</span>
          </Link>

          <div className="glass-card p-8">
            <h1 className="text-2xl font-extrabold text-gray-900 mb-1">Sign In</h1>
            <p className="text-gray-500 text-sm mb-8">
              Don't have an account?{' '}
              <Link to="/register" className="text-primary-600 font-medium hover:underline">
                Register here
              </Link>
            </p>

            {/* Demo credentials hint */}
            <div className="bg-primary-50 border border-primary-100 rounded-xl p-3 mb-6 text-xs text-primary-700">
              <strong>Demo:</strong> user@pgrkam.gov.in / password &nbsp;|&nbsp; admin@pgrkam.gov.in / password
            </div>

            <form onSubmit={handleSubmit} className="space-y-5" noValidate>
              {/* Email */}
              <div>
                <label className="text-sm font-medium text-gray-700 mb-1.5 block">
                  Email Address
                </label>
                <div className="relative">
                  <FiMail className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={16} />
                  <input
                    type="email"
                    value={form.email}
                    onChange={(e) => setForm({ ...form, email: e.target.value })}
                    placeholder="you@example.com"
                    className={`input-field pl-10 ${errors.email ? 'border-red-400 focus:ring-red-400' : ''}`}
                  />
                </div>
                {errors.email && <p className="text-red-500 text-xs mt-1">{errors.email}</p>}
              </div>

              {/* Password */}
              <div>
                <label className="text-sm font-medium text-gray-700 mb-1.5 block">
                  Password
                </label>
                <div className="relative">
                  <FiLock className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={16} />
                  <input
                    type={showPw ? 'text' : 'password'}
                    value={form.password}
                    onChange={(e) => setForm({ ...form, password: e.target.value })}
                    placeholder="••••••••"
                    className={`input-field pl-10 pr-10 ${errors.password ? 'border-red-400 focus:ring-red-400' : ''}`}
                  />
                  <button
                    type="button"
                    onClick={() => setShowPw(!showPw)}
                    className="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                  >
                    {showPw ? <FiEyeOff size={16} /> : <FiEye size={16} />}
                  </button>
                </div>
                {errors.password && <p className="text-red-500 text-xs mt-1">{errors.password}</p>}
              </div>

              <button type="submit" disabled={loading} className="btn-primary w-full justify-center flex items-center gap-2">
                {loading ? <Loader size="sm" text="" /> : <><FiLogIn size={16} /> Sign In</>}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  )
}
