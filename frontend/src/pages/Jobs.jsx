import { useState } from 'react'
import { FiSearch, FiMapPin, FiBriefcase, FiClock, FiDollarSign, FiFilter } from 'react-icons/fi'
import { dummyJobs, formatDate } from '../utils/helpers'

const jobTypes = ['All', 'Government', 'Private']
const locations = ['All', 'Chandigarh', 'Mohali', 'Ludhiana', 'Amritsar', 'Patiala']

export default function Jobs() {
  const [search, setSearch]     = useState('')
  const [type,   setType]       = useState('All')
  const [loc,    setLoc]        = useState('All')
  const [selected, setSelected] = useState(null)

  const filtered = dummyJobs.filter((j) => {
    const matchSearch = j.title.toLowerCase().includes(search.toLowerCase()) ||
                        j.department.toLowerCase().includes(search.toLowerCase())
    const matchType = type === 'All' || j.type === type.toLowerCase()
    const matchLoc  = loc === 'All'  || j.location === loc
    return matchSearch && matchType && matchLoc
  })

  return (
    <div className="max-w-screen-xl mx-auto px-6 py-10">
      {/* Page header */}
      <div className="mb-8">
        <h1 className="text-3xl font-extrabold text-gray-900">Job Listings</h1>
        <p className="text-gray-500 mt-1">
          Discover {dummyJobs.length}+ government and private sector opportunities across Punjab.
        </p>
      </div>

      {/* Filters */}
      <div className="glass-card p-4 mb-6 flex flex-col sm:flex-row gap-3">
        <div className="relative flex-1">
          <FiSearch className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={16} />
          <input
            type="text"
            value={search}
            onChange={(e) => setSearch(e.target.value)}
            placeholder="Search job title or department…"
            className="input-field pl-9 text-sm"
          />
        </div>
        <select value={type} onChange={(e) => setType(e.target.value)} className="input-field text-sm w-full sm:w-40">
          {jobTypes.map((t) => <option key={t}>{t}</option>)}
        </select>
        <select value={loc} onChange={(e) => setLoc(e.target.value)} className="input-field text-sm w-full sm:w-40">
          {locations.map((l) => <option key={l}>{l}</option>)}
        </select>
      </div>

      {/* Results count */}
      <p className="text-sm text-gray-500 mb-4">
        Showing <strong>{filtered.length}</strong> results
      </p>

      {/* Job list */}
      <div className="grid gap-4">
        {filtered.length === 0 ? (
          <div className="text-center py-20 text-gray-400">
            <FiBriefcase size={40} className="mx-auto mb-3 opacity-50" />
            <p>No jobs match your filters.</p>
          </div>
        ) : (
          filtered.map((job) => (
            <div
              key={job.id}
              onClick={() => setSelected(selected?.id === job.id ? null : job)}
              className="glass-card p-5 cursor-pointer hover:-translate-y-0.5 transition-all duration-200"
            >
              <div className="flex flex-col sm:flex-row sm:items-center gap-4">
                {/* Icon */}
                <div className="w-12 h-12 rounded-2xl bg-primary-100 flex items-center justify-center flex-shrink-0">
                  <FiBriefcase className="text-primary-600" size={22} />
                </div>

                {/* Info */}
                <div className="flex-1 min-w-0">
                  <div className="flex items-start justify-between gap-2">
                    <h3 className="font-bold text-gray-900 text-lg">{job.title}</h3>
                    <span className={`badge flex-shrink-0 ${job.type === 'government' ? 'badge-blue' : 'badge-green'}`}>
                      {job.type === 'government' ? '🏛️ Government' : '🏢 Private'}
                    </span>
                  </div>
                  <p className="text-gray-600 text-sm mt-0.5">{job.department}</p>
                  <div className="flex flex-wrap gap-4 mt-2 text-sm text-gray-500">
                    <span className="flex items-center gap-1"><FiMapPin size={13} /> {job.location}</span>
                    <span className="flex items-center gap-1"><FiDollarSign size={13} /> {job.salary}</span>
                    <span className="flex items-center gap-1"><FiClock size={13} /> Deadline: {formatDate(job.deadline)}</span>
                  </div>
                </div>

                {/* Apply button */}
                <button
                  onClick={(e) => e.stopPropagation()}
                  className="btn-primary text-sm flex-shrink-0"
                >
                  Apply Now
                </button>
              </div>

              {/* Expanded details */}
              {selected?.id === job.id && (
                <div className="mt-4 pt-4 border-t border-gray-100 animate-fade-in text-sm text-gray-600 space-y-2">
                  <p>📅 Posted: {formatDate(job.posted)}</p>
                  <p>📋 This is a {job.type} sector position with the {job.department}.</p>
                  <p>📄 Candidates meeting the eligibility criteria may apply online through the official portal before {formatDate(job.deadline)}.</p>
                  <button className="btn-primary mt-2 text-sm">Apply for This Job</button>
                </div>
              )}
            </div>
          ))
        )}
      </div>
    </div>
  )
}
