import { useState, useEffect } from 'react'
import { Link } from 'react-router-dom'
import { FiBookOpen, FiClock, FiMapPin, FiHash, FiRefreshCw, FiAlertCircle } from 'react-icons/fi'
import { userAPI } from '../api/axios'
import toast from 'react-hot-toast'

const STATUS_STYLES = {
  enrolled:  { label: 'Enrolled',    bg: 'bg-yellow-100 text-yellow-700' },
  active:    { label: 'In Progress', bg: 'bg-blue-100 text-blue-700'    },
  completed: { label: 'Completed',   bg: 'bg-green-100 text-green-700'  },
  cancelled: { label: 'Cancelled',   bg: 'bg-red-100 text-red-700'      },
}

function formatDate(d) {
  if (!d) return '—'
  return new Date(d).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' })
}

export default function MyEnrollments() {
  const [enrollments, setEnrollments] = useState([])
  const [loading,     setLoading]     = useState(true)

  const load = async () => {
    setLoading(true)
    try {
      const { data } = await userAPI.getEnrollments()
      setEnrollments(data.enrollments || [])
    } catch {
      toast.error('Could not load enrollments')
    } finally {
      setLoading(false)
    }
  }

  useEffect(() => { load() }, [])

  return (
    <div className="max-w-5xl mx-auto px-4 py-8">
      {/* Header */}
      <div className="flex items-center justify-between mb-8">
        <div>
          <h1 className="text-2xl font-extrabold text-gray-900">My Enrollments</h1>
          <p className="text-gray-500 text-sm mt-1">Training programs you have enrolled in</p>
        </div>
        <button
          onClick={load}
          disabled={loading}
          className="flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 text-gray-600 text-sm font-medium hover:bg-gray-50 transition"
        >
          <FiRefreshCw size={14} className={loading ? 'animate-spin' : ''} />
          Refresh
        </button>
      </div>

      {/* Loading skeleton */}
      {loading && (
        <div className="space-y-4">
          {[1, 2, 3].map(i => (
            <div key={i} className="glass-card p-5 animate-pulse">
              <div className="h-5 bg-gray-200 rounded w-1/3 mb-3" />
              <div className="h-4 bg-gray-100 rounded w-1/2 mb-2" />
              <div className="h-3 bg-gray-100 rounded w-1/4" />
            </div>
          ))}
        </div>
      )}

      {/* Empty state */}
      {!loading && enrollments.length === 0 && (
        <div className="text-center py-24 text-gray-400">
          <FiBookOpen size={48} className="mx-auto mb-4 opacity-40" />
          <p className="text-lg font-semibold text-gray-500">No enrollments yet</p>
          <p className="text-sm mt-1">Browse training programs and click "Enroll Now" to get started</p>
          <Link to="/training" className="inline-block mt-5 btn-primary px-6 py-2.5 text-sm">
            Browse Training
          </Link>
        </div>
      )}

      {/* Enrollments list */}
      {!loading && enrollments.length > 0 && (
        <div className="space-y-4">
          {enrollments.map((e) => {
            const statusKey = (e.status || 'enrolled').toLowerCase()
            const st = STATUS_STYLES[statusKey] || STATUS_STYLES.enrolled
            return (
              <div key={e.id} className="glass-card p-5 animate-slide-up">
                <div className="flex flex-col sm:flex-row sm:items-start gap-4">
                  {/* Icon */}
                  <div className="w-11 h-11 rounded-2xl bg-primary-100 flex items-center justify-center flex-shrink-0">
                    <FiBookOpen className="text-primary-600" size={20} />
                  </div>

                  {/* Details */}
                  <div className="flex-1 min-w-0">
                    <div className="flex items-start justify-between gap-3 flex-wrap">
                      <div>
                        <h3 className="font-bold text-gray-900 text-base">{e.title}</h3>
                        <p className="text-sm text-gray-500 mt-0.5">{e.provider}</p>
                      </div>
                      <span className={`px-3 py-1 rounded-full text-xs font-bold flex-shrink-0 ${st.bg}`}>
                        {st.label}
                      </span>
                    </div>

                    {/* Meta row */}
                    <div className="flex flex-wrap gap-4 mt-3 text-xs text-gray-500">
                      <span className="flex items-center gap-1">
                        <FiMapPin size={11} /> {e.category || 'Training'}
                      </span>
                      <span className="flex items-center gap-1">
                        <FiClock size={11} /> Enrolled: {formatDate(e.enrolled_at)}
                      </span>
                      <span className="flex items-center gap-1 font-medium text-primary-700">
                        {e.fee || 'Free'} · {e.duration}
                      </span>
                    </div>

                    {/* Enrollment ID */}
                    <div className="mt-3 flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 w-fit">
                      <FiHash size={13} className="text-gray-400" />
                      <span className="text-xs text-gray-500">Enrollment ID:</span>
                      <span className="text-xs font-mono font-bold text-gray-800 select-all">
                        PGRKAM-ENR-{String(e.id).padStart(6, '0')}
                      </span>
                    </div>

                    {/* Status note */}
                    {statusKey === 'enrolled' && (
                      <div className="mt-3 flex items-start gap-2 text-xs text-yellow-700 bg-yellow-50 border border-yellow-100 rounded-xl p-2.5">
                        <FiAlertCircle size={13} className="mt-0.5 flex-shrink-0" />
                        Your enrollment is confirmed. You will be contacted with batch schedule and timings.
                      </div>
                    )}
                    {statusKey === 'completed' && (
                      <div className="mt-3 flex items-start gap-2 text-xs text-green-700 bg-green-50 border border-green-100 rounded-xl p-2.5">
                        🎉 Congratulations! You have successfully completed this training program.
                      </div>
                    )}
                  </div>
                </div>
              </div>
            )
          })}
        </div>
      )}

      {/* Summary bar */}
      {!loading && enrollments.length > 0 && (
        <div className="mt-8 grid grid-cols-2 sm:grid-cols-4 gap-4">
          {['enrolled', 'active', 'completed', 'cancelled'].map((s) => {
            const count = enrollments.filter(e => (e.status || 'enrolled').toLowerCase() === s).length
            const st    = STATUS_STYLES[s]
            return (
              <div key={s} className="glass-card p-4 text-center">
                <div className={`inline-block px-2 py-0.5 rounded-full text-xs font-bold mb-2 ${st.bg}`}>{st.label}</div>
                <div className="text-2xl font-extrabold text-gray-900">{count}</div>
              </div>
            )
          })}
        </div>
      )}
    </div>
  )
}
