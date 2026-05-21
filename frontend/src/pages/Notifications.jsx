import { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import {
  FiBell, FiBriefcase, FiBookOpen, FiAlertCircle,
  FiInfo, FiCheck, FiCheckCircle,
} from 'react-icons/fi'
import { userAPI } from '../api/axios'
import toast from 'react-hot-toast'

function timeAgo(dateStr) {
  if (!dateStr) return ''
  const diff = Math.floor((Date.now() - new Date(dateStr)) / 1000)
  if (diff < 60)    return 'Just now'
  if (diff < 3600)  return `${Math.floor(diff / 60)}m ago`
  if (diff < 86400) return `${Math.floor(diff / 3600)}h ago`
  if (diff < 604800) return `${Math.floor(diff / 86400)}d ago`
  return new Date(dateStr).toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' })
}

const typeConfig = {
  job: {
    icon: FiBriefcase, bg: 'bg-blue-100', text: 'text-blue-600',
    border: 'border-l-blue-500', badge: 'bg-blue-50 text-blue-700 border-blue-200', label: 'Job',
  },
  training: {
    icon: FiBookOpen, bg: 'bg-green-100', text: 'text-green-600',
    border: 'border-l-green-500', badge: 'bg-green-50 text-green-700 border-green-200', label: 'Training',
  },
  alert: {
    icon: FiAlertCircle, bg: 'bg-orange-100', text: 'text-orange-600',
    border: 'border-l-orange-500', badge: 'bg-orange-50 text-orange-700 border-orange-200', label: 'Alert',
  },
  default: {
    icon: FiInfo, bg: 'bg-gray-100', text: 'text-gray-500',
    border: 'border-l-gray-400', badge: 'bg-gray-50 text-gray-600 border-gray-200', label: 'Info',
  },
  info: {
    icon: FiInfo, bg: 'bg-purple-100', text: 'text-purple-600',
    border: 'border-l-purple-400', badge: 'bg-purple-50 text-purple-700 border-purple-200', label: 'Info',
  },
}
function getConfig(type) { return typeConfig[type] || typeConfig.default }

export default function Notifications() {
  const navigate = useNavigate()
  const [notifications, setNotifications] = useState([])
  const [loading,       setLoading]       = useState(true)
  const [markingAll,    setMarkingAll]    = useState(false)
  const [filter,        setFilter]        = useState('all')

  useEffect(() => {
    userAPI.getNotifications()
      .then(({ data }) => setNotifications(data.data || data || []))
      .catch(() => toast.error('Failed to load notifications'))
      .finally(() => setLoading(false))
  }, [])

  const markRead = async (id) => {
    try {
      await userAPI.markNotifRead(id)
      setNotifications(prev => prev.map(n => n.id === id ? { ...n, is_read: true } : n))
    } catch {/* silent */}
  }

  const markAllRead = async () => {
    setMarkingAll(true)
    try {
      await Promise.all(notifications.filter(n => !n.is_read).map(n => userAPI.markNotifRead(n.id)))
      setNotifications(prev => prev.map(n => ({ ...n, is_read: true })))
      toast.success('All notifications marked as read')
    } catch { toast.error('Failed to mark all as read') }
    finally { setMarkingAll(false) }
  }

  const handleClick = (notif) => {
    if (!notif.is_read) markRead(notif.id)
    if (notif.link) navigate(notif.link)
  }

  const unreadCount = notifications.filter(n => !n.is_read).length
  const filtered = notifications.filter(n =>
    filter === 'unread' ? !n.is_read : filter === 'read' ? n.is_read : true
  )

  return (
    <div className="max-w-3xl mx-auto space-y-6 animate-fade-in">

      {/* Header */}
      <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
          <h1 className="text-2xl font-bold text-gray-900 flex items-center gap-2">
            <FiBell size={22} className="text-primary-600" />
            Notifications
            {unreadCount > 0 && (
              <span className="text-xs bg-red-500 text-white px-2 py-0.5 rounded-full font-semibold">
                {unreadCount} new
              </span>
            )}
          </h1>
          <p className="text-gray-500 mt-0.5 text-sm">Your alerts, updates and activity from PGRKAM</p>
        </div>
        {unreadCount > 0 && (
          <button
            onClick={markAllRead} disabled={markingAll}
            className="flex items-center gap-1.5 text-sm bg-primary-50 text-primary-700 border border-primary-200
                       px-4 py-2 rounded-xl font-medium hover:bg-primary-100 transition disabled:opacity-50 self-start sm:self-auto"
          >
            <FiCheck size={14} />
            {markingAll ? 'Marking...' : 'Mark all as read'}
          </button>
        )}
      </div>

      {/* Stats strip */}
      <div className="grid grid-cols-3 gap-3">
        {[
          { key: 'all',    label: 'All',    count: notifications.length,               color: 'bg-gray-50 border-gray-200 text-gray-700'   },
          { key: 'unread', label: 'Unread', count: unreadCount,                         color: 'bg-blue-50 border-blue-200 text-blue-700'   },
          { key: 'read',   label: 'Read',   count: notifications.length - unreadCount,  color: 'bg-green-50 border-green-200 text-green-700' },
        ].map(({ key, label, count, color }) => (
          <button key={key} onClick={() => setFilter(key)}
            className={`rounded-2xl border p-4 text-center transition hover:shadow-md
                        ${color} ${filter === key ? 'ring-2 ring-primary-400 shadow-md' : 'opacity-80'}`}
          >
            <p className="text-2xl font-bold">{count}</p>
            <p className="text-xs font-medium mt-0.5">{label}</p>
          </button>
        ))}
      </div>

      {/* List */}
      {loading ? (
        <div className="flex items-center justify-center h-48">
          <div className="w-10 h-10 border-4 border-primary-200 border-t-primary-600 rounded-full animate-spin" />
        </div>
      ) : filtered.length === 0 ? (
        <div className="glass-card p-14 text-center">
          <div className="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
            <FiBell size={32} className="text-gray-300" />
          </div>
          <h3 className="text-lg font-semibold text-gray-700 mb-1">
            {filter === 'unread' ? 'No unread notifications' : filter === 'read' ? 'No read notifications' : 'No notifications yet'}
          </h3>
          <p className="text-gray-400 text-sm max-w-xs mx-auto">
            Apply for jobs or enroll in training — you will see updates here.
          </p>
        </div>
      ) : (
        <div className="space-y-2">
          {filtered.map(notif => {
            const cfg = getConfig(notif.type)
            const Icon = cfg.icon
            return (
              <div key={notif.id} onClick={() => handleClick(notif)}
                className={`group bg-white rounded-2xl border shadow-sm hover:shadow-md
                            transition-all duration-200 cursor-pointer flex overflow-hidden
                            ${!notif.is_read ? `border-l-4 ${cfg.border} border-r border-t border-b border-gray-100` : 'border-gray-100'}`}
              >
                <div className="flex-1 flex gap-4 p-4">
                  <div className={`flex-shrink-0 w-10 h-10 rounded-xl ${cfg.bg} flex items-center justify-center mt-0.5`}>
                    <Icon size={18} className={cfg.text} />
                  </div>
                  <div className="flex-1 min-w-0">
                    <div className="flex items-start justify-between gap-2">
                      <div className="flex items-center gap-2 flex-wrap">
                        <p className={`text-sm leading-snug ${notif.is_read ? 'text-gray-600' : 'text-gray-900 font-semibold'}`}>
                          {notif.title || 'Notification'}
                        </p>
                        <span className={`text-[10px] font-medium px-1.5 py-0.5 rounded-full border ${cfg.badge}`}>
                          {cfg.label}
                        </span>
                        {!notif.is_read && <span className="w-2 h-2 rounded-full bg-primary-500 inline-block" />}
                      </div>
                      <span className="text-[11px] text-gray-400 whitespace-nowrap flex-shrink-0">{timeAgo(notif.created_at)}</span>
                    </div>
                    <p className="text-xs text-gray-500 mt-1 leading-relaxed">{notif.message}</p>
                    {notif.link && (
                      <p className="text-xs text-primary-600 font-medium mt-1.5 group-hover:underline">View details</p>
                    )}
                  </div>
                </div>
                <div className="flex items-center pr-4">
                  {notif.is_read
                    ? <FiCheckCircle size={16} className="text-green-400" />
                    : <div className="w-2.5 h-2.5 rounded-full bg-primary-500" />}
                </div>
              </div>
            )
          })}
        </div>
      )}
    </div>
  )
}