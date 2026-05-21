import { NavLink, useNavigate } from 'react-router-dom'
import { useAuth } from '../context/AuthContext'
import { useSidebar } from '../context/SidebarContext'
import {
  FiHome, FiBriefcase, FiBookOpen, FiFileText,
  FiMessageSquare, FiUser, FiBell, FiLogOut,
  FiSettings, FiPieChart, FiUsers, FiLayers,
  FiBookmark, FiAlertCircle,
} from 'react-icons/fi'
import { MdWork, MdSchool } from 'react-icons/md'

// Navigation items for regular users
const userNav = [
  { label: 'Dashboard',          to: '/dashboard',       icon: FiHome          },
  { label: 'Jobs',               to: '/jobs',            icon: FiBriefcase     },
  { label: 'My Applications',    to: '/my-applications', icon: MdWork          },
  { label: 'Saved Jobs',         to: '/saved-jobs',      icon: FiBookmark      },
  { label: 'Training',           to: '/training',        icon: FiBookOpen      },
  { label: 'My Enrollments',     to: '/my-enrollments',  icon: MdSchool        },
  { label: 'Employment Schemes', to: '/schemes',         icon: FiLayers        },
  { label: 'Resume',             to: '/resume',          icon: FiFileText      },
  { label: 'Career Counselling', to: '/counselling',     icon: FiMessageSquare },
  { label: 'Job Alerts',         to: '/job-alerts',      icon: FiAlertCircle   },
  { label: 'Notifications',      to: '/notifications',   icon: FiBell          },
  { label: 'Profile & Settings', to: '/profile',         icon: FiUser          },
]

// Navigation items for admin users
const adminNav = [
  { label: 'Admin Home',  to: '/admin',           icon: FiHome    },
  { label: 'Users',       to: '/admin/users',      icon: FiUsers   },
  { label: 'Services',    to: '/admin/services',   icon: FiLayers  },
  { label: 'Jobs',        to: '/admin/jobs',       icon: FiBriefcase },
  { label: 'Reports',     to: '/reports',          icon: FiPieChart },
  { label: 'Settings',    to: '/admin/settings',   icon: FiSettings },
]

export default function Sidebar({ isOpen }) {
  const { user, logout, isAdmin } = useAuth()
  const { closeSidebar } = useSidebar()
  const navigate  = useNavigate()
  const navItems  = isAdmin ? adminNav : userNav

  const handleLogout = async () => {
    await logout()
    navigate('/login')
  }

  return (
    <>
      {/* Sidebar panel */}
      <aside
        className={`fixed top-16 left-0 h-[calc(100vh-4rem)] z-40 flex flex-col w-64
                    bg-white border-r border-gray-200 shadow-lg transition-transform duration-300
                    ${isOpen ? 'translate-x-0' : '-translate-x-full'}`}
      >
        {/* User info */}
          <div className="p-4 border-b border-gray-100">
          <div className="flex items-center gap-3">
            <div className="w-10 h-10 rounded-full bg-gradient-to-br from-primary-600 to-blue-400
                            flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
              {user?.name?.charAt(0).toUpperCase() || 'U'}
            </div>
            <div className="overflow-hidden">
              <p className="text-sm font-semibold text-gray-800 truncate">{user?.name}</p>
              <span className={`badge ${isAdmin ? 'badge-blue' : 'badge-green'} mt-0.5`}>
                {isAdmin ? 'Admin' : 'User'}
              </span>
            </div>
          </div>
        </div>

        {/* Nav links */}
        <nav className="flex-1 py-4 px-2 space-y-1 overflow-y-auto scrollbar-thin">
          {navItems.map(({ label, to, icon: Icon }) => (
            <NavLink
              key={label}
              to={to}
              onClick={closeSidebar}
              className={({ isActive }) =>
                `nav-item ${isActive ? 'nav-item-active' : ''}`
              }
            >
              <Icon size={18} className="flex-shrink-0" />
              <span className="truncate">{label}</span>
            </NavLink>
          ))}
        </nav>

        {/* Logout */}
        <div className="p-3 border-t border-gray-100">
          <button
            onClick={handleLogout}
            className="nav-item w-full text-red-500 hover:bg-red-50 hover:text-red-600"
          >
            <FiLogOut size={18} className="flex-shrink-0" />
            <span className="truncate">Logout</span>
          </button>
        </div>
      </aside>
    </>
  )
}
