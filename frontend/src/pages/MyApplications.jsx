import { useState, useEffect } from 'react'
import { Link } from 'react-router-dom'
import { FiBriefcase, FiClock, FiMapPin, FiHash, FiRefreshCw, FiAlertCircle } from 'react-icons/fi'
import { userAPI } from '../api/axios'
import toast from 'react-hot-toast'

const STATUS_STYLES = {
  pending:     { label: 'Under Review',  bg: 'bg-yellow-100 text-yellow-700' },
  reviewed:    { label: 'Reviewed',      bg: 'bg-blue-100 text-blue-700' },
  shortlisted: { label: 'Shortlisted!',  bg: 'bg-green-100 text-green-700' },
  rejected:    { label: 'Not Selected',  bg: 'bg-red-100 text-red-700' },
}

function formatDate(d) {
  if (!d) return '—'
  return new Date(d).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' })
}

export default function MyApplications() {
  const [apps,    setApps]    = useState([])
  const [loading, setLoading] = useState(true)

  const load = async () => {
    setLoading(true)
    try {
      const { data } = await userAPI.getApplications()
      setApps(data.applications || [])
    } catch {
      toast.error('Could not load applications')
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
          <h1 className="text-2xl font-extrabold text-gray-900">My Job Applications</h1>
          <p className="text-gray-500 text-sm mt-1">Track status of all jobs you have applied for</p>
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
      {!loading && apps.length === 0 && (
        <div className="text-center py-24 text-gray-400">
          <FiBriefcase size={48} className="mx-auto mb-4 opacity-40" />
          <p className="text-lg font-semibold text-gray-500">No applications yet</p>
          <p className="text-sm mt-1">Browse jobs and click "Apply Now" to get started</p>
          <Link to="/jobs" className="inline-block mt-5 btn-primary px-6 py-2.5 text-sm">
            Browse Jobs
          </Link>
        </div>
      )}

      {/* Applications list */}
      {!loading && apps.length > 0 && (
        <div className="space-y-4">
          {apps.map((app) => {
            const st = STATUS_STYLES[app.status] || STATUS_STYLES.pending
            return (
              <div key={app.id} className="glass-card p-5 animate-slide-up">
                <div className="flex flex-col sm:flex-row sm:items-start gap-4">
                  {/* Job icon */}
                  <div className="w-11 h-11 rounded-2xl bg-primary-100 flex items-center justify-center flex-shrink-0">
                    <FiBriefcase className="text-primary-600" size={20} />
                  </div>

                  {/* Details */}
                  <div className="flex-1 min-w-0">
                    <div className="flex items-start justify-between gap-3 flex-wrap">
                      <div>
                        <h3 className="font-bold text-gray-900 text-base">{app.job_title}</h3>
                        <p className="text-sm text-gray-500 mt-0.5">{app.department}</p>
                      </div>
                      <span className={`px-3 py-1 rounded-full text-xs font-bold flex-shrink-0 ${st.bg}`}>
                        {st.label}
                      </span>
                    </div>

                    {/* Meta row */}
                    <div className="flex flex-wrap gap-4 mt-3 text-xs text-gray-500">
                      <span className="flex items-center gap-1">
                        <FiMapPin size={11} /> {app.location}
                      </span>
                      <span className="flex items-center gap-1">
                        <FiClock size={11} /> Applied: {formatDate(app.applied_at)}
                      </span>
                      <span className="flex items-center gap-1 font-medium text-primary-700">
                        {app.salary_range}
                      </span>
                    </div>

                    {/* Application Ref */}
                    <div className="mt-3 flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 w-fit">
                      <FiHash size={13} className="text-gray-400" />
                      <span className="text-xs text-gray-500">Application ID:</span>
                      <span className="text-xs font-mono font-bold text-gray-800 select-all">{app.application_ref}</span>
                    </div>

                    {/* Status timeline note */}
                    {app.status === 'pending' && (
                      <div className="mt-3 flex items-start gap-2 text-xs text-yellow-700 bg-yellow-50 border border-yellow-100 rounded-xl p-2.5">
                        <FiAlertCircle size={13} className="mt-0.5 flex-shrink-0" />
                        Your application is under review. You will be contacted on your registered mobile/email if shortlisted.
                      </div>
                    )}
                    {app.status === 'shortlisted' && (
                      <div className="mt-3 flex items-start gap-2 text-xs text-green-700 bg-green-50 border border-green-100 rounded-xl p-2.5">
                        🎉 Congratulations! You have been shortlisted. Please check your email and mobile for interview details.
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
      {!loading && apps.length > 0 && (
        <div className="mt-8 grid grid-cols-2 sm:grid-cols-4 gap-4">
          {['pending', 'reviewed', 'shortlisted', 'rejected'].map((s) => {
            const count = apps.filter(a => a.status === s).length
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
