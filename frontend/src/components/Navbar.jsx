import { useState } from 'react'
import { Link, useNavigate } from 'react-router-dom'
import { useAuth } from '../context/AuthContext'
import {
  FiBell, FiMenu, FiX, FiUser, FiLogOut,
  FiChevronDown, FiSearch,
} from 'react-icons/fi'
import { MdWork } from 'react-icons/md'

export default function Navbar({ onMenuClick, sidebarOpen }) {
  const { user, logout, isAuthenticated, isAdmin } = useAuth()
  const navigate = useNavigate()
  const [dropdownOpen, setDropdownOpen] = useState(false)
  const [mobileOpen,   setMobileOpen]   = useState(false)

  const handleLogout = async () => {
    await logout()
    navigate('/login')
  }

  return (
    <nav className="fixed top-0 inset-x-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 shadow-sm">
      <div className="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex items-center justify-between h-16">

          {/* Left – logo + sidebar toggle */}
          <div className="flex items-center gap-3">
            {isAuthenticated && (
              <button
                onClick={onMenuClick}
                className="p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition"
                aria-label="Toggle sidebar"
              >
                {sidebarOpen ? <FiX size={20} /> : <FiMenu size={20} />}
              </button>
            )}

            <Link to="/" className="flex items-center gap-2">
              <div className="w-9 h-9 bg-gradient-to-br from-primary-700 to-blue-500 rounded-xl flex items-center justify-center shadow">
                <MdWork className="text-white" size={20} />
              </div>
              <div className="hidden sm:block">
                <p className="text-sm font-bold text-primary-800 leading-tight">PGRKAM</p>
                <p className="text-xs text-gray-500 leading-tight">Employment Portal</p>
              </div>
            </Link>
          </div>

          {/* Centre – nav links (desktop) */}
          <div className="hidden md:flex items-center gap-1">
            {[
              { label: 'Home',     to: '/'          },
              { label: 'Services', to: '/services'  },
              { label: 'Jobs',     to: '/jobs'      },
              { label: 'Training', to: '/training'  },
              { label: 'About',    to: '/about'     },
              { label: 'Contact',  to: '/contact'   },
            ].map(({ label, to }) => (
              <Link
                key={to}
                to={to}
                className="px-3 py-2 rounded-lg text-sm font-medium text-gray-600
                           hover:text-primary-700 hover:bg-primary-50 transition"
              >
                {label}
              </Link>
            ))}
          </div>

          {/* Right – auth / user menu */}
          <div className="flex items-center gap-2">
            {isAuthenticated ? (
              <>
                {/* Notification bell */}
                <Link
                  to="/dashboard"
                  className="relative p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition"
                >
                  <FiBell size={20} />
                  <span className="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full" />
                </Link>

                {/* User dropdown */}
                <div className="relative">
                  <button
                    onClick={() => setDropdownOpen(!dropdownOpen)}
                    className="flex items-center gap-2 pl-2 pr-3 py-1.5 rounded-xl
                               hover:bg-gray-100 transition"
                  >
                    <div className="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center text-white font-semibold text-sm">
                      {user?.name?.charAt(0).toUpperCase() || 'U'}
                    </div>
                    <span className="hidden sm:block text-sm font-medium text-gray-700">
                      {user?.name?.split(' ')[0]}
                    </span>
                    <FiChevronDown size={14} className="text-gray-500" />
                  </button>

                  {dropdownOpen && (
                    <div className="absolute right-0 mt-2 w-52 bg-white border border-gray-100
                                    rounded-2xl shadow-lg py-2 z-50 animate-fade-in">
                      <div className="px-4 py-2 border-b border-gray-100">
                        <p className="text-sm font-semibold text-gray-800">{user?.name}</p>
                        <p className="text-xs text-gray-500 truncate">{user?.email}</p>
                      </div>
                      <Link
                        to="/dashboard"
                        onClick={() => setDropdownOpen(false)}
                        className="flex items-center gap-3 px-4 py-2 text-sm text-gray-600 hover:bg-primary-50 hover:text-primary-700"
                      >
                        <FiUser size={15} /> My Dashboard
                      </Link>
                      {isAdmin && (
                        <Link
                          to="/admin"
                          onClick={() => setDropdownOpen(false)}
                          className="flex items-center gap-3 px-4 py-2 text-sm text-gray-600 hover:bg-primary-50 hover:text-primary-700"
                        >
                          <FiSearch size={15} /> Admin Panel
                        </Link>
                      )}
                      <button
                        onClick={handleLogout}
                        className="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-500 hover:bg-red-50"
                      >
                        <FiLogOut size={15} /> Logout
                      </button>
                    </div>
                  )}
                </div>
              </>
            ) : (
              <div className="flex items-center gap-2">
                <Link to="/login"    className="btn-secondary text-sm py-2 px-4">Login</Link>
                <Link to="/register" className="btn-primary  text-sm py-2 px-4">Register</Link>
              </div>
            )}

            {/* Mobile hamburger */}
            <button
              onClick={() => setMobileOpen(!mobileOpen)}
              className="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition"
            >
              {mobileOpen ? <FiX size={20} /> : <FiMenu size={20} />}
            </button>
          </div>
        </div>

        {/* Mobile nav menu */}
        {mobileOpen && (
          <div className="md:hidden border-t border-gray-100 py-3 space-y-1 animate-fade-in">
            {[
              { label: 'Home',     to: '/'          },
              { label: 'Services', to: '/services'  },
              { label: 'Jobs',     to: '/jobs'      },
              { label: 'Training', to: '/training'  },
              { label: 'About',    to: '/about'     },
              { label: 'Contact',  to: '/contact'   },
            ].map(({ label, to }) => (
              <Link
                key={to}
                to={to}
                onClick={() => setMobileOpen(false)}
                className="block px-4 py-2 text-sm font-medium text-gray-600
                           hover:text-primary-700 hover:bg-primary-50 rounded-lg"
              >
                {label}
              </Link>
            ))}
          </div>
        )}
      </div>
    </nav>
  )
}
