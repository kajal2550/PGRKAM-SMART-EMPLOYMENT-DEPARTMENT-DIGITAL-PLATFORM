import { useState, useEffect } from 'react'
import { useAuth } from '../context/AuthContext'
import { useNavigate, Link } from 'react-router-dom'
import { userAPI, jobsAPI } from '../api/axios'
import {
  FiBriefcase, FiBookOpen, FiFileText, FiMessageSquare, FiBell,
  FiBookmark, FiList, FiArrowRight, FiMapPin, FiClock,
  FiCheckCircle, FiAlertCircle, FiInfo, FiTrendingUp, FiAward,
  FiCalendar, FiChevronRight, FiUser,
} from 'react-icons/fi'
import { formatDate } from '../utils/helpers'

export default function Dashboard() {
  const { user } = useAuth()
  const navigate = useNavigate()
  const [profile,       setProfile]       = useState(null)
  const [recentJobs,    setRecentJobs]    = useState([])
  const [notifications, setNotifications] = useState([])
  const [appCount,      setAppCount]      = useState('—')
  const [loading,       setLoading]       = useState(true)

  useEffect(() => {
    Promise.all([
      userAPI.getProfile(),
      jobsAPI.getAll({ per_page: 6 }),
      userAPI.getNotifications(),
      userAPI.getApplications(),
    ]).then(([profileRes, jobsRes, notifRes, appsRes]) => {
      setProfile(profileRes.data)
      setRecentJobs((jobsRes.data.data || jobsRes.data).slice(0, 6))
      setNotifications((notifRes.data.data || notifRes.data).slice(0, 6))
      setAppCount((appsRes.data.applications || []).length)
    }).catch(() => {}).finally(() => setLoading(false))
  }, [])

  const firstName = user?.name?.split(' ')[0] || 'User'
  const hour = new Date().getHours()
  const greeting = hour < 12 ? 'Good Morning' : hour < 17 ? 'Good Afternoon' : 'Good Evening'

  const resumeComplete = !!profile?.user?.resume
  const enrolledCount  = profile?.user?.enrolledTrainings?.length ?? 0
  const savedCount     = profile?.saved_jobs_count ?? '—'
  const unreadCount    = notifications.filter(n => !n.is_read).length

  const stats = [
    { label: 'Jobs Applied',      value: appCount,      icon: FiList,      bg: 'bg-primary-600',  link: '/my-applications' },
    { label: 'Saved Jobs',        value: savedCount,    icon: FiBookmark,  bg: 'bg-blue-500',     link: '/saved-jobs'      },
    { label: 'Trainings Enrolled',value: enrolledCount, icon: FiBookOpen,  bg: 'bg-primary-700',  link: '/my-enrollments'  },
    { label: 'Resume',            value: resumeComplete ? 'Done ✓' : 'Pending', icon: FiFileText, bg: resumeComplete ? 'bg-primary-800' : 'bg-orange-500', link: '/resume' },
  ]

  const notifIcon = (type) => {
    if (type === 'job')      return <FiBriefcase size={14} className="text-primary-600" />
    if (type === 'training') return <FiBookOpen  size={14} className="text-blue-600" />
    if (type === 'alert')    return <FiAlertCircle size={14} className="text-orange-500" />
    return <FiInfo size={14} className="text-gray-400" />
  }

  return (
    <div className="min-h-screen bg-gray-50 dark:bg-gray-950">

      {/* ── Hero Greeting ───────────────────────────────────────────────── */}
      <div className="bg-gradient-to-br from-primary-700 via-primary-800 to-primary-900 px-6 py-8">
        <div className="max-w-screen-xl mx-auto flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div className="flex items-center gap-4">
            <div className="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center text-white text-2xl font-extrabold flex-shrink-0">
              {firstName.charAt(0).toUpperCase()}
            </div>
            <div>
              <p className="text-white/70 text-sm font-medium">{greeting} 👋</p>
              <h1 className="text-2xl font-extrabold text-white">{user?.name}</h1>
              <p className="text-white/60 text-xs mt-0.5">{user?.email} · {user?.district || 'Punjab'}</p>
            </div>
          </div>
          <div className="flex gap-3">
            <Link to="/jobs" className="bg-white text-primary-700 font-semibold px-5 py-2.5 rounded-xl text-sm hover:bg-blue-50 transition shadow">
              Browse Jobs →
            </Link>
            <Link to="/training" className="bg-white/10 border border-white/20 text-white font-semibold px-5 py-2.5 rounded-xl text-sm hover:bg-white/20 transition">
              Trainings
            </Link>
          </div>
        </div>
      </div>

      <div className="max-w-screen-xl mx-auto px-6 py-8 space-y-8">

        {/* ── Stat Cards ──────────────────────────────────────────────────── */}
        <div className="grid grid-cols-2 xl:grid-cols-4 gap-4">
          {loading
            ? [1,2,3,4].map(i => (
                <div key={i} className="bg-white dark:bg-gray-800 rounded-2xl p-5 animate-pulse border border-gray-100 dark:border-gray-700">
                  <div className="h-8 w-8 bg-gray-200 dark:bg-gray-600 rounded-xl mb-3" />
                  <div className="h-7 bg-gray-200 dark:bg-gray-600 rounded w-1/2 mb-1" />
                  <div className="h-3 bg-gray-100 dark:bg-gray-700 rounded w-3/4" />
                </div>
              ))
            : stats.map((s) => (
                <button key={s.label} onClick={() => navigate(s.link)}
                  className="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 hover:shadow-lg hover:-translate-y-0.5 transition-all text-left group">
                  <div className={`w-10 h-10 ${s.bg} rounded-xl flex items-center justify-center mb-3`}>
                    <s.icon size={18} className="text-white" />
                  </div>
                  <p className="text-2xl font-extrabold text-gray-900 dark:text-white">{s.value}</p>
                  <p className="text-xs text-gray-500 dark:text-gray-400 mt-0.5 font-medium">{s.label}</p>
                  <p className="text-xs text-primary-600 mt-2 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
                    View details <FiArrowRight size={11} />
                  </p>
                </button>
              ))
          }
        </div>

        {/* ── Main Grid ───────────────────────────────────────────────────── */}
        <div className="grid lg:grid-cols-3 gap-6">

          {/* Left: Recent Jobs + Quick Actions */}
          <div className="lg:col-span-2 space-y-6">

            {/* Recent Jobs */}
            <div className="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
              <div className="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <div className="flex items-center gap-2">
                  <div className="w-8 h-8 bg-primary-100 dark:bg-primary-900/40 rounded-xl flex items-center justify-center">
                    <FiBriefcase size={15} className="text-primary-600" />
                  </div>
                  <h2 className="font-bold text-gray-900 dark:text-white">Latest Job Openings</h2>
                </div>
                <Link to="/jobs" className="text-xs font-semibold text-primary-600 hover:text-primary-700 flex items-center gap-1">
                  View all <FiChevronRight size={13} />
                </Link>
              </div>
              {loading ? (
                <div className="divide-y divide-gray-50 dark:divide-gray-700">
                  {[1,2,3,4].map(i => (
                    <div key={i} className="flex items-center gap-4 px-6 py-4 animate-pulse">
                      <div className="w-10 h-10 bg-gray-200 dark:bg-gray-700 rounded-xl flex-shrink-0" />
                      <div className="flex-1 space-y-1.5">
                        <div className="h-3.5 bg-gray-200 dark:bg-gray-700 rounded w-1/2" />
                        <div className="h-3 bg-gray-100 dark:bg-gray-600 rounded w-1/3" />
                      </div>
                      <div className="w-16 h-6 bg-gray-100 dark:bg-gray-700 rounded-lg" />
                    </div>
                  ))}
                </div>
              ) : recentJobs.length === 0 ? (
                <p className="text-gray-400 text-sm px-6 py-8 text-center">No jobs available yet.</p>
              ) : (
                <div className="divide-y divide-gray-50 dark:divide-gray-700/50">
                  {recentJobs.map((job) => (
                    <div key={job.id} className="flex items-center gap-4 px-6 py-3.5 hover:bg-primary-50/50 dark:hover:bg-primary-900/10 transition group cursor-pointer"
                      onClick={() => navigate('/jobs')}>
                      <div className="w-10 h-10 rounded-xl bg-primary-100 dark:bg-primary-900/40 flex items-center justify-center flex-shrink-0">
                        <FiBriefcase className="text-primary-600" size={16} />
                      </div>
                      <div className="flex-1 min-w-0">
                        <p className="font-semibold text-gray-800 dark:text-gray-200 text-sm group-hover:text-primary-700 dark:group-hover:text-primary-400 truncate">{job.title}</p>
                        <p className="text-xs text-gray-400 flex items-center gap-2 mt-0.5">
                          <FiMapPin size={10} /> {job.department} · {job.location}
                        </p>
                      </div>
                      <div className="text-right flex-shrink-0 space-y-1">
                        {job.salary_range && <p className="text-xs font-semibold text-gray-600 dark:text-gray-300">{job.salary_range}</p>}
                        <span className={`inline-block text-xs font-semibold px-2 py-0.5 rounded-full ${
                          job.type === 'government'
                            ? 'bg-primary-100 text-primary-700 dark:bg-primary-900/40 dark:text-primary-400'
                            : 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400'
                        }`}>{job.type === 'government' ? 'Govt' : 'Private'}</span>
                      </div>
                    </div>
                  ))}
                </div>
              )}
            </div>

            {/* Quick Actions */}
            <div className="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6">
              <h3 className="font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <FiTrendingUp size={16} className="text-primary-600" /> Quick Actions
              </h3>
              <div className="grid grid-cols-2 sm:grid-cols-4 gap-3">
                {[
                  { label: 'Find Jobs',         to: '/jobs',        icon: FiBriefcase,    bg: 'bg-primary-100 dark:bg-primary-900/40',  ico: 'text-primary-700 dark:text-primary-400' },
                  { label: 'Skill Training',    to: '/training',    icon: FiBookOpen,     bg: 'bg-blue-100 dark:bg-blue-900/30',         ico: 'text-blue-700 dark:text-blue-400'        },
                  { label: 'Update Resume',     to: '/resume',      icon: FiFileText,     bg: 'bg-primary-100 dark:bg-primary-900/40',  ico: 'text-primary-700 dark:text-primary-400' },
                  { label: 'Get Counselling',   to: '/counselling', icon: FiMessageSquare,bg: 'bg-blue-100 dark:bg-blue-900/30',         ico: 'text-blue-700 dark:text-blue-400'        },
                  { label: 'My Applications',   to: '/my-applications', icon: FiList,     bg: 'bg-primary-100 dark:bg-primary-900/40',  ico: 'text-primary-700 dark:text-primary-400' },
                  { label: 'Saved Jobs',        to: '/saved-jobs',  icon: FiBookmark,     bg: 'bg-blue-100 dark:bg-blue-900/30',         ico: 'text-blue-700 dark:text-blue-400'        },
                  { label: 'My Enrollments',    to: '/my-enrollments', icon: FiAward,     bg: 'bg-primary-100 dark:bg-primary-900/40',  ico: 'text-primary-700 dark:text-primary-400' },
                  { label: 'Services',          to: '/services',    icon: FiCalendar,     bg: 'bg-blue-100 dark:bg-blue-900/30',         ico: 'text-blue-700 dark:text-blue-400'        },
                ].map(({ label, to, icon: Icon, bg, ico }) => (
                  <Link key={label} to={to}
                    className="flex flex-col items-center gap-2 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-primary-300 dark:hover:border-primary-700 hover:shadow-md transition-all group text-center">
                    <div className={`w-10 h-10 ${bg} rounded-xl flex items-center justify-center`}>
                      <Icon size={18} className={ico} />
                    </div>
                    <span className="text-xs font-semibold text-gray-600 dark:text-gray-400 group-hover:text-primary-700 dark:group-hover:text-primary-400 leading-tight">{label}</span>
                  </Link>
                ))}
              </div>
            </div>
          </div>

          {/* Right: Profile + Notifications */}
          <div className="space-y-5">

            {/* Profile Card */}
            <div className="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
              <div className="bg-gradient-to-r from-primary-600 to-primary-800 px-6 py-5 text-center">
                <div className="w-16 h-16 rounded-2xl bg-white/20 border-2 border-white/40 flex items-center justify-center text-white text-2xl font-extrabold mx-auto mb-2">
                  {user?.name?.charAt(0).toUpperCase()}
                </div>
                <p className="font-bold text-white">{user?.name}</p>
                <p className="text-white/70 text-xs mt-0.5">{user?.email}</p>
                <span className="inline-block mt-2 bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full">Active</span>
              </div>
              <div className="px-6 py-4 space-y-3">
                <div className="flex items-center justify-between text-sm">
                  <span className="text-gray-500 dark:text-gray-400">District</span>
                  <span className="font-semibold text-gray-700 dark:text-gray-300">{user?.district || 'Not set'}</span>
                </div>
                <div className="flex items-center justify-between text-sm">
                  <span className="text-gray-500 dark:text-gray-400">Resume</span>
                  <span className={`font-semibold flex items-center gap-1 ${resumeComplete ? 'text-primary-600' : 'text-orange-500'}`}>
                    {resumeComplete ? <><FiCheckCircle size={13} /> Complete</> : <><FiAlertCircle size={13} /> Pending</>}
                  </span>
                </div>
                <div className="flex items-center justify-between text-sm">
                  <span className="text-gray-500 dark:text-gray-400">Enrollments</span>
                  <span className="font-semibold text-gray-700 dark:text-gray-300">{enrolledCount} training{enrolledCount !== 1 ? 's' : ''}</span>
                </div>
                <Link to="/resume" className="w-full flex items-center justify-center gap-2 border-2 border-primary-200 dark:border-primary-800 text-primary-700 dark:text-primary-400 font-semibold py-2.5 rounded-xl hover:bg-primary-50 dark:hover:bg-primary-900/20 transition text-sm mt-1">
                  <FiFileText size={14} /> Update Resume
                </Link>
              </div>
            </div>

            {/* Notifications */}
            <div className="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
              <div className="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                <div className="flex items-center gap-2">
                  <div className="w-8 h-8 bg-orange-100 dark:bg-orange-900/30 rounded-xl flex items-center justify-center">
                    <FiBell size={14} className="text-orange-500" />
                  </div>
                  <h3 className="font-bold text-gray-900 dark:text-white text-sm">Notifications</h3>
                </div>
                {unreadCount > 0 && (
                  <span className="bg-primary-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">{unreadCount}</span>
                )}
              </div>
              {loading ? (
                <div className="px-5 py-4 space-y-3">
                  {[1,2,3].map(i => <div key={i} className="h-10 bg-gray-100 dark:bg-gray-700 rounded-xl animate-pulse" />)}
                </div>
              ) : notifications.length === 0 ? (
                <p className="text-gray-400 text-sm px-5 py-6 text-center">No notifications yet.</p>
              ) : (
                <div className="divide-y divide-gray-50 dark:divide-gray-700/50 max-h-72 overflow-y-auto">
                  {notifications.map((n) => (
                    <div key={n.id} className={`flex items-start gap-3 px-5 py-3 ${!n.is_read ? 'bg-blue-50/60 dark:bg-blue-900/10' : ''}`}>
                      <div className={`w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5 ${!n.is_read ? 'bg-primary-100 dark:bg-primary-900/40' : 'bg-gray-100 dark:bg-gray-700'}`}>
                        {notifIcon(n.type)}
                      </div>
                      <div className="flex-1 min-w-0">
                        <p className={`text-xs leading-relaxed ${!n.is_read ? 'text-gray-800 dark:text-gray-200 font-medium' : 'text-gray-500 dark:text-gray-400'}`}>
                          {n.message}
                        </p>
                        {!n.is_read && <div className="w-1.5 h-1.5 bg-primary-500 rounded-full mt-1" />}
                      </div>
                    </div>
                  ))}
                </div>
              )}
            </div>

            {/* Upcoming Deadline Tip */}
            <div className="bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl p-5 text-white">
              <div className="flex items-center gap-2 mb-2">
                <FiCalendar size={16} className="text-white/80" />
                <p className="font-bold text-sm">Pro Tip</p>
              </div>
              <p className="text-white/80 text-xs leading-relaxed">
                Apply to jobs <strong className="text-white">at least 7 days</strong> before the deadline. Early applicants get shortlisted faster!
              </p>
              <Link to="/jobs" className="mt-3 flex items-center gap-1 text-xs font-semibold text-white/90 hover:text-white transition">
                Browse open jobs <FiArrowRight size={11} />
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}
