import { useState, useEffect } from 'react'
import { Link, useNavigate } from 'react-router-dom'
import { FiBookmark, FiMapPin, FiBriefcase, FiClock, FiDollarSign, FiTrash2, FiSearch } from 'react-icons/fi'
import { jobsAPI, userAPI } from '../api/axios'
import { formatDate } from '../utils/helpers'
import toast from 'react-hot-toast'

export default function SavedJobs() {
  const navigate = useNavigate()
  const [jobs,    setJobs]    = useState([])
  const [loading, setLoading] = useState(true)
  const [removing, setRemoving] = useState({})

  useEffect(() => {
    jobsAPI.getSaved()
      .then(({ data }) => setJobs(data.data || data))
      .catch(() => toast.error('Failed to load saved jobs'))
      .finally(() => setLoading(false))
  }, [])

  const handleRemove = async (jobId) => {
    setRemoving(p => ({ ...p, [jobId]: true }))
    try {
      await userAPI.unsaveJob(jobId)
      setJobs(prev => prev.filter(j => j.id !== jobId))
      toast.success('Removed from saved jobs')
    } catch {
      toast.error('Could not remove job')
    } finally {
      setRemoving(p => ({ ...p, [jobId]: false }))
    }
  }

  return (
    <div className="max-w-4xl mx-auto space-y-6 animate-fade-in">
      {/* Header */}
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-2xl font-bold text-gray-900">Saved Jobs</h1>
          <p className="text-gray-500 mt-0.5 text-sm">Jobs you bookmarked for later</p>
        </div>
        <Link to="/jobs" className="btn-primary px-4 py-2 text-sm flex items-center gap-2">
          <FiSearch size={15} /> Browse Jobs
        </Link>
      </div>

      {loading ? (
        <div className="flex items-center justify-center h-40">
          <div className="w-8 h-8 border-4 border-primary-200 border-t-primary-600 rounded-full animate-spin" />
        </div>
      ) : jobs.length === 0 ? (
        <div className="glass-card p-12 text-center">
          <FiBookmark size={48} className="mx-auto text-gray-300 mb-4" />
          <h3 className="text-lg font-semibold text-gray-700 mb-1">No saved jobs yet</h3>
          <p className="text-gray-500 text-sm mb-4">Browse jobs and click the bookmark icon to save them here.</p>
          <Link to="/jobs" className="btn-primary px-6 py-2 inline-block">Browse Jobs</Link>
        </div>
      ) : (
        <div className="space-y-4">
          <p className="text-sm text-gray-500">{jobs.length} saved job{jobs.length !== 1 ? 's' : ''}</p>
          {jobs.map(job => (
            <div key={job.id} className="glass-card p-5 hover:shadow-md transition-shadow">
              <div className="flex items-start justify-between gap-4">
                <div className="flex-1 min-w-0">
                  <div className="flex items-center gap-2 mb-1">
                    <span className={`text-xs px-2 py-0.5 rounded-full font-medium ${
                      job.type === 'government'
                        ? 'bg-blue-100 text-blue-700'
                        : 'bg-purple-100 text-purple-700'
                    }`}>
                      {job.type === 'government' ? 'Govt' : 'Private'}
                    </span>
                    {job.application_deadline && new Date(job.application_deadline) < new Date() && (
                      <span className="text-xs px-2 py-0.5 rounded-full bg-red-100 text-red-600 font-medium">Expired</span>
                    )}
                  </div>
                  <h3 className="text-base font-bold text-gray-900 truncate">{job.title}</h3>
                  <p className="text-sm text-gray-600 mt-0.5">{job.department}</p>
                  <div className="flex flex-wrap gap-3 mt-2 text-xs text-gray-500">
                    <span className="flex items-center gap-1"><FiMapPin size={11} />{job.location}</span>
                    {job.salary_range && <span className="flex items-center gap-1"><FiDollarSign size={11} />{job.salary_range}</span>}
                    {job.application_deadline && (
                      <span className="flex items-center gap-1"><FiClock size={11} />Deadline: {formatDate(job.application_deadline)}</span>
                    )}
                    {job.vacancies && <span className="flex items-center gap-1"><FiBriefcase size={11} />{job.vacancies} vacancies</span>}
                  </div>
                </div>
                <div className="flex flex-col gap-2 flex-shrink-0">
                  <button
                    onClick={() => navigate('/jobs')}
                    className="btn-primary text-xs px-4 py-1.5"
                  >
                    Apply Now
                  </button>
                  <button
                    onClick={() => handleRemove(job.id)}
                    disabled={removing[job.id]}
                    className="flex items-center justify-center gap-1 text-xs px-4 py-1.5 rounded-lg border border-red-200 text-red-500 hover:bg-red-50 transition disabled:opacity-50"
                  >
                    <FiTrash2 size={12} />
                    {removing[job.id] ? 'Removing…' : 'Remove'}
                  </button>
                </div>
              </div>
            </div>
          ))}
        </div>
      )}
    </div>
  )
}
