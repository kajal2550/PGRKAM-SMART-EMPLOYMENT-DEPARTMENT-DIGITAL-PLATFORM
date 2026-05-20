import { useAuth } from '../context/AuthContext'
import DashboardCard from '../components/DashboardCard'
import { FiBriefcase, FiBookOpen, FiFileText, FiMessageSquare, FiBell, FiUser } from 'react-icons/fi'
import { dummyJobs, formatDate } from '../utils/helpers'
import { Link } from 'react-router-dom'

const stats = [
  { title: 'Saved Jobs',          value: 12,  icon: <FiBriefcase size={22} />,     color: 'blue',   change: '+3',  trend: 'up'   },
  { title: 'Training Enrolled',   value: 2,   icon: <FiBookOpen  size={22} />,     color: 'green',  change: '+1',  trend: 'up'   },
  { title: 'Resume Score',        value: '78%',icon: <FiFileText size={22} />,     color: 'orange', change: '+5%', trend: 'up'   },
  { title: 'Counselling Sessions',value: 1,   icon: <FiMessageSquare size={22} />, color: 'purple', change: null,  trend: null   },
]

export default function Dashboard() {
  const { user } = useAuth()

  return (
    <div className="space-y-8 animate-fade-in">
      {/* Greeting */}
      <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-extrabold text-gray-900">
            Hello, {user?.name?.split(' ')[0]} 👋
          </h1>
          <p className="text-gray-500 text-sm mt-1">
            Here's what's happening with your employment journey today.
          </p>
        </div>
        <Link to="/jobs" className="btn-primary text-sm">
          Browse New Jobs
        </Link>
      </div>

      {/* Stat cards */}
      <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
        {stats.map((s) => (
          <DashboardCard key={s.title} {...s} />
        ))}
      </div>

      {/* Main content grid */}
      <div className="grid lg:grid-cols-3 gap-6">
        {/* Recent Jobs */}
        <div className="lg:col-span-2 glass-card p-6">
          <div className="flex items-center justify-between mb-5">
            <h2 className="font-bold text-gray-900">Recent Job Listings</h2>
            <Link to="/jobs" className="text-sm text-primary-600 hover:underline">View all</Link>
          </div>
          <div className="space-y-3">
            {dummyJobs.slice(0, 5).map((job) => (
              <div key={job.id}
                   className="flex items-center gap-4 p-3 rounded-xl hover:bg-primary-50 transition group">
                <div className="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center flex-shrink-0">
                  <FiBriefcase className="text-primary-600" size={18} />
                </div>
                <div className="flex-1 min-w-0">
                  <p className="font-semibold text-gray-800 text-sm group-hover:text-primary-700 truncate">
                    {job.title}
                  </p>
                  <p className="text-xs text-gray-500">{job.department} · {job.location}</p>
                </div>
                <div className="text-right flex-shrink-0">
                  <p className="text-xs font-medium text-gray-700">{job.salary}</p>
                  <span className={`badge ${job.type === 'government' ? 'badge-blue' : 'badge-green'} mt-1`}>
                    {job.type === 'government' ? 'Govt' : 'Private'}
                  </span>
                </div>
              </div>
            ))}
          </div>
        </div>

        {/* Right column */}
        <div className="space-y-5">
          {/* Profile card */}
          <div className="glass-card p-5 text-center">
            <div className="w-16 h-16 rounded-full bg-primary-600 flex items-center justify-center
                            text-white text-2xl font-bold mx-auto mb-3">
              {user?.name?.charAt(0).toUpperCase()}
            </div>
            <p className="font-bold text-gray-900">{user?.name}</p>
            <p className="text-sm text-gray-500">{user?.email}</p>
            <span className="badge badge-green mt-2">Active</span>
            <Link to="/resume" className="btn-secondary w-full mt-4 text-sm flex justify-center">
              <FiFileText size={14} className="mr-2" /> Update Resume
            </Link>
          </div>

          {/* Quick links */}
          <div className="glass-card p-5">
            <h3 className="font-bold text-gray-900 mb-4">Quick Actions</h3>
            <div className="space-y-2">
              {[
                { label: 'Book Counselling', to: '/counselling', icon: FiMessageSquare, color: 'text-purple-600' },
                { label: 'My Training',      to: '/training',    icon: FiBookOpen,      color: 'text-green-600' },
                { label: 'Notifications',    to: '/dashboard',   icon: FiBell,          color: 'text-orange-600' },
                { label: 'My Profile',       to: '/dashboard',   icon: FiUser,          color: 'text-blue-600' },
              ].map(({ label, to, icon: Icon, color }) => (
                <Link
                  key={label}
                  to={to}
                  className="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition text-sm"
                >
                  <Icon size={16} className={color} />
                  <span className="text-gray-700">{label}</span>
                </Link>
              ))}
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}
