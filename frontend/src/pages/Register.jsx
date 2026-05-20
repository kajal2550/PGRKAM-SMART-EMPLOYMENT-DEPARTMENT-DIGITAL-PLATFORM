import { useState } from 'react'
import { Link, useNavigate } from 'react-router-dom'
import { useAuth } from '../context/AuthContext'
import { FiUser, FiMail, FiLock, FiPhone, FiEye, FiEyeOff, FiUserPlus } from 'react-icons/fi'
import { MdWork } from 'react-icons/md'
import Loader from '../components/Loader'

export default function Register() {
  const { register }   = useAuth()
  const navigate       = useNavigate()
  const [form, setForm]    = useState({ name: '', email: '', phone: '', password: '', password_confirmation: '' })
  const [errors, setErrors]= useState({})
  const [loading, setLoading] = useState(false)
  const [showPw, setShowPw]   = useState(false)

  const validate = () => {
    const e = {}
    if (!form.name)    e.name    = 'Full name is required'
    if (!form.email)   e.email   = 'Email is required'
    else if (!/\S+@\S+\.\S+/.test(form.email)) e.email = 'Enter a valid email'
    if (!form.phone)   e.phone   = 'Phone number is required'
    if (!form.password) e.password = 'Password is required'
    else if (form.password.length < 8) e.password = 'Minimum 8 characters'
    if (form.password !== form.password_confirmation)
      e.password_confirmation = 'Passwords do not match'
    return e
  }

  const handleSubmit = async (e) => {
    e.preventDefault()
    const errs = validate()
    if (Object.keys(errs).length) { setErrors(errs); return }
    setLoading(true)
    const result = await register(form)
    setLoading(false)
    if (result.success) navigate('/dashboard')
    else if (result.errors) setErrors(result.errors)
  }

  const field = (name) => ({
    value: form[name],
    onChange: (e) => { setForm({ ...form, [name]: e.target.value }); setErrors({ ...errors, [name]: '' }) },
  })

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
            Join Punjab's Smart<br />Employment Network
          </h2>
          <p className="text-white/70 max-w-sm">
            Register free and get instant access to job listings, training programs,
            resume builder, and personalised career guidance.
          </p>
        </div>
        <p className="text-white/40 text-sm">© {new Date().getFullYear()} PGRKAM – Government of Punjab</p>
      </div>

      {/* Right panel */}
      <div className="flex-1 flex items-center justify-center p-6 bg-gray-50 overflow-y-auto">
        <div className="w-full max-w-md py-8">
          <Link to="/" className="lg:hidden flex items-center gap-2 mb-8">
            <div className="w-9 h-9 bg-primary-600 rounded-xl flex items-center justify-center">
              <MdWork className="text-white" size={20} />
            </div>
            <span className="font-bold text-primary-800">PGRKAM</span>
          </Link>

          <div className="glass-card p-8">
            <h1 className="text-2xl font-extrabold text-gray-900 mb-1">Create Account</h1>
            <p className="text-gray-500 text-sm mb-8">
              Already registered?{' '}
              <Link to="/login" className="text-primary-600 font-medium hover:underline">Sign in</Link>
            </p>

            <form onSubmit={handleSubmit} className="space-y-5" noValidate>
              {/* Full Name */}
              <div>
                <label className="text-sm font-medium text-gray-700 mb-1.5 block">Full Name</label>
                <div className="relative">
                  <FiUser className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={16} />
                  <input type="text" {...field('name')} placeholder="Harpreet Singh"
                    className={`input-field pl-10 ${errors.name ? 'border-red-400' : ''}`} />
                </div>
                {errors.name && <p className="text-red-500 text-xs mt-1">{errors.name}</p>}
              </div>

              {/* Email */}
              <div>
                <label className="text-sm font-medium text-gray-700 mb-1.5 block">Email Address</label>
                <div className="relative">
                  <FiMail className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={16} />
                  <input type="email" {...field('email')} placeholder="you@example.com"
                    className={`input-field pl-10 ${errors.email ? 'border-red-400' : ''}`} />
                </div>
                {errors.email && <p className="text-red-500 text-xs mt-1">{errors.email}</p>}
              </div>

              {/* Phone */}
              <div>
                <label className="text-sm font-medium text-gray-700 mb-1.5 block">Phone Number</label>
                <div className="relative">
                  <FiPhone className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={16} />
                  <input type="tel" {...field('phone')} placeholder="+91 98765 43210"
                    className={`input-field pl-10 ${errors.phone ? 'border-red-400' : ''}`} />
                </div>
                {errors.phone && <p className="text-red-500 text-xs mt-1">{errors.phone}</p>}
              </div>

              {/* Password */}
              <div>
                <label className="text-sm font-medium text-gray-700 mb-1.5 block">Password</label>
                <div className="relative">
                  <FiLock className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={16} />
                  <input type={showPw ? 'text' : 'password'} {...field('password')} placeholder="Min 8 characters"
                    className={`input-field pl-10 pr-10 ${errors.password ? 'border-red-400' : ''}`} />
                  <button type="button" onClick={() => setShowPw(!showPw)}
                    className="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    {showPw ? <FiEyeOff size={16} /> : <FiEye size={16} />}
                  </button>
                </div>
                {errors.password && <p className="text-red-500 text-xs mt-1">{errors.password}</p>}
              </div>

              {/* Confirm Password */}
              <div>
                <label className="text-sm font-medium text-gray-700 mb-1.5 block">Confirm Password</label>
                <div className="relative">
                  <FiLock className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={16} />
                  <input type="password" {...field('password_confirmation')} placeholder="Repeat password"
                    className={`input-field pl-10 ${errors.password_confirmation ? 'border-red-400' : ''}`} />
                </div>
                {errors.password_confirmation && <p className="text-red-500 text-xs mt-1">{errors.password_confirmation}</p>}
              </div>

              <p className="text-xs text-gray-400">
                By registering you agree to our{' '}
                <a href="#" className="text-primary-600 hover:underline">Terms of Service</a> and{' '}
                <a href="#" className="text-primary-600 hover:underline">Privacy Policy</a>.
              </p>

              <button type="submit" disabled={loading} className="btn-primary w-full justify-center flex items-center gap-2">
                {loading ? <Loader size="sm" text="" /> : <><FiUserPlus size={16} /> Create Account</>}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  )
}
