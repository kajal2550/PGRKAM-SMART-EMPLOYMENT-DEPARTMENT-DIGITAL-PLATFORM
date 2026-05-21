import { useState, useEffect } from 'react'
import DashboardCard from '../components/DashboardCard'
import { adminAPI, jobsAPI, trainingAPI } from '../api/axios'
import { FiUsers, FiBriefcase, FiBookOpen, FiMessageSquare, FiTrash2, FiEye, FiRefreshCw } from 'react-icons/fi'
import { formatDate } from '../utils/helpers'
import toast from 'react-hot-toast'

export default function AdminDashboard() {
  const [stats,     setStats]     = useState(null)
  const [users,     setUsers]     = useState([])
  const [jobs,      setJobs]      = useState([])
  const [trainings, setTrainings] = useState([])
  const [tab,       setTab]       = useState('users')
  const [loading,   setLoading]   = useState(true)

  const loadData = async () => {
    setLoading(true)
    try {
      const [dashRes, usersRes, jobsRes, trainRes] = await Promise.all([
        adminAPI.getDashboard(),
        adminAPI.getUsers(),
        jobsAPI.getAll({ per_page: 20 }),
        trainingAPI.getAll({ per_page: 20 }),
      ])
      setStats(dashRes.data.stats)
      setUsers(usersRes.data.data || usersRes.data)
      setJobs((jobsRes.data.data || jobsRes.data).slice(0, 20))
      setTrainings((trainRes.data.data || trainRes.data).slice(0, 20))
    } catch {
      toast.error('Failed to load admin data')
    } finally {
      setLoading(false)
    }
  }

  useEffect(() => { loadData() }, [])

  const deleteUser = async (id) => {
    if (!window.confirm('Delete this user?')) return
    try {
      await adminAPI.deleteUser(id)
      setUsers((p) => p.filter((u) => u.id !== id))
      toast.success('User deleted')
    } catch (err) {
      toast.error(err.response?.data?.message || 'Cannot delete user')
    }
  }

  const adminStats = stats ? [
    { title: 'Total Users',        value: stats.total_users,        icon: <FiUsers size={22} />,         color: 'blue'   },
    { title: 'Active Jobs',        value: stats.active_jobs,        icon: <FiBriefcase size={22} />,     color: 'green'  },
    { title: 'Training Programs',  value: stats.training_programs,  icon: <FiBookOpen size={22} />,      color: 'orange' },
    { title: 'Counselling Reqs',   value: stats.counselling_reqs,   icon: <FiMessageSquare size={22} />, color: 'purple' },
  ] : []

  return (
    <div className="space-y-8 animate-fade-in">
      {/* Header */}
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-2xl font-extrabold text-gray-900">Admin Dashboard</h1>
          <p className="text-gray-500 text-sm mt-1">Manage PGRKAM services and users.</p>
        </div>
        <button onClick={loadData} className="btn-secondary text-sm flex items-center gap-2">
          <FiRefreshCw size={14} /> Refresh
        </button>
      </div>

      {/* Stats */}
      {loading ? (
        <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
          {[1,2,3,4].map((i) => (
            <div key={i} className="glass-card p-6 animate-pulse">
              <div className="h-4 bg-gray-200 rounded w-3/4 mb-3" />
              <div className="h-8 bg-gray-200 rounded w-1/2" />
            </div>
          ))}
        </div>
      ) : (
        <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
          {adminStats.map((s) => <DashboardCard key={s.title} {...s} />)}
        </div>
      )}

      {/* Tabs */}
      <div className="flex gap-1 border-b border-gray-200">
        {['users', 'jobs', 'trainings'].map((t) => (
          <button
            key={t}
            onClick={() => setTab(t)}
            className={`px-5 py-2.5 text-sm font-medium capitalize border-b-2 transition ${
              tab === t ? 'border-primary-600 text-primary-700' : 'border-transparent text-gray-500 hover:text-gray-700'
            }`}
          >
            {t}
          </button>
        ))}
      </div>

      {/* Users Table */}
      {tab === 'users' && (
        <div className="glass-card overflow-hidden">
          <div className="overflow-x-auto">
            <table className="w-full text-sm">
              <thead>
                <tr className="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                  <th className="px-6 py-3">User</th>
                  <th className="px-6 py-3">Role</th>
                  <th className="px-6 py-3">Status</th>
                  <th className="px-6 py-3">Joined</th>
                  <th className="px-6 py-3">Actions</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-gray-100">
                {users.length === 0 ? (
                  <tr><td colSpan={5} className="px-6 py-10 text-center text-gray-400">No users found.</td></tr>
                ) : users.map((u) => (
                  <tr key={u.id} className="hover:bg-gray-50 transition">
                    <td className="px-6 py-4">
                      <div className="flex items-center gap-3">
                        <div className="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center
                                        text-white font-semibold text-sm flex-shrink-0">
                          {u.name.charAt(0)}
                        </div>
                        <div>
                          <p className="font-medium text-gray-900">{u.name}</p>
                          <p className="text-xs text-gray-400">{u.email}</p>
                        </div>
                      </div>
                    </td>
                    <td className="px-6 py-4">
                      <span className={`badge ${u.role === 'admin' ? 'badge-blue' : 'badge-green'}`}>
                        {u.role}
                      </span>
                    </td>
                    <td className="px-6 py-4">
                      <span className={`badge ${u.is_active ? 'badge-green' : 'badge-yellow'}`}>
                        {u.is_active ? 'active' : 'inactive'}
                      </span>
                    </td>
                    <td className="px-6 py-4 text-gray-500">{formatDate(u.created_at)}</td>
                    <td className="px-6 py-4">
                      <button onClick={() => deleteUser(u.id)}
                        className="p-1.5 text-gray-400 hover:text-red-500 transition rounded">
                        <FiTrash2 size={15} />
                      </button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      )}

      {/* Jobs Table */}
      {tab === 'jobs' && (
        <div className="glass-card overflow-hidden">
          <div className="overflow-x-auto">
            <table className="w-full text-sm">
              <thead>
                <tr className="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                  <th className="px-6 py-3">Job Title</th>
                  <th className="px-6 py-3">Department</th>
                  <th className="px-6 py-3">Type</th>
                  <th className="px-6 py-3">Deadline</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-gray-100">
                {jobs.length === 0 ? (
                  <tr><td colSpan={4} className="px-6 py-10 text-center text-gray-400">No jobs found.</td></tr>
                ) : jobs.map((j) => (
                  <tr key={j.id} className="hover:bg-gray-50">
                    <td className="px-6 py-4 font-medium text-gray-900">{j.title}</td>
                    <td className="px-6 py-4 text-gray-500">{j.department}</td>
                    <td className="px-6 py-4">
                      <span className={`badge ${j.type === 'government' ? 'badge-blue' : 'badge-green'}`}>
                        {j.type}
                      </span>
                    </td>
                    <td className="px-6 py-4 text-gray-500">{formatDate(j.application_deadline)}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      )}

      {/* Training Table */}
      {tab === 'trainings' && (
        <div className="glass-card overflow-hidden">
          <div className="overflow-x-auto">
            <table className="w-full text-sm">
              <thead>
                <tr className="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                  <th className="px-6 py-3">Program</th>
                  <th className="px-6 py-3">Provider</th>
                  <th className="px-6 py-3">Category</th>
                  <th className="px-6 py-3">Seats</th>
                  <th className="px-6 py-3">Fee</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-gray-100">
                {trainings.length === 0 ? (
                  <tr><td colSpan={5} className="px-6 py-10 text-center text-gray-400">No programs found.</td></tr>
                ) : trainings.map((t) => (
                  <tr key={t.id} className="hover:bg-gray-50">
                    <td className="px-6 py-4 font-medium text-gray-900">{t.title}</td>
                    <td className="px-6 py-4 text-gray-500">{t.provider}</td>
                    <td className="px-6 py-4"><span className="badge badge-green">{t.category}</span></td>
                    <td className="px-6 py-4 text-gray-500">{t.enrolled_count}/{t.total_seats}</td>
                    <td className="px-6 py-4 font-medium text-primary-700">{t.fee}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      )}
    </div>
  )
}

  return (
    <div className="space-y-8 animate-fade-in">
      {/* Header */}
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-2xl font-extrabold text-gray-900">Admin Dashboard</h1>
          <p className="text-gray-500 text-sm mt-1">Manage PGRKAM services and users.</p>
        </div>
        <button className="btn-primary text-sm flex items-center gap-2">
          <FiPlus size={15} /> Add Service
        </button>
      </div>

      {/* Stats */}
      <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
        {adminStats.map((s) => <DashboardCard key={s.title} {...s} />)}
      </div>

      {/* Tabs */}
      <div className="flex gap-1 border-b border-gray-200">
        {['users', 'jobs', 'trainings'].map((t) => (
          <button
            key={t}
            onClick={() => setTab(t)}
            className={`px-5 py-2.5 text-sm font-medium capitalize border-b-2 transition ${
              tab === t ? 'border-primary-600 text-primary-700' : 'border-transparent text-gray-500 hover:text-gray-700'
            }`}
          >
            {t}
          </button>
        ))}
      </div>

      {/* Users Table */}
      {tab === 'users' && (
        <div className="glass-card overflow-hidden">
          <div className="overflow-x-auto">
            <table className="w-full text-sm">
              <thead>
                <tr className="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                  <th className="px-6 py-3">User</th>
                  <th className="px-6 py-3">Role</th>
                  <th className="px-6 py-3">Status</th>
                  <th className="px-6 py-3">Joined</th>
                  <th className="px-6 py-3">Actions</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-gray-100">
                {users.map((u) => (
                  <tr key={u.id} className="hover:bg-gray-50 transition">
                    <td className="px-6 py-4">
                      <div className="flex items-center gap-3">
                        <div className="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center
                                        text-white font-semibold text-sm flex-shrink-0">
                          {u.name.charAt(0)}
                        </div>
                        <div>
                          <p className="font-medium text-gray-900">{u.name}</p>
                          <p className="text-xs text-gray-400">{u.email}</p>
                        </div>
                      </div>
                    </td>
                    <td className="px-6 py-4">
                      <span className={`badge ${u.role === 'admin' ? 'badge-blue' : 'badge-green'}`}>
                        {u.role}
                      </span>
                    </td>
                    <td className="px-6 py-4">
                      <span className={`badge ${u.status === 'active' ? 'badge-green' : 'badge-yellow'}`}>
                        {u.status}
                      </span>
                    </td>
                    <td className="px-6 py-4 text-gray-500">{formatDate(u.joined)}</td>
                    <td className="px-6 py-4">
                      <div className="flex gap-2">
                        <button className="p-1.5 text-gray-400 hover:text-primary-600 transition rounded">
                          <FiEye size={15} />
                        </button>
                        <button onClick={() => deleteUser(u.id)}
                          className="p-1.5 text-gray-400 hover:text-red-500 transition rounded">
                          <FiTrash2 size={15} />
                        </button>
                      </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      )}

      {/* Jobs Table */}
      {tab === 'jobs' && (
        <div className="glass-card overflow-hidden">
          <div className="overflow-x-auto">
            <table className="w-full text-sm">
              <thead>
                <tr className="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                  <th className="px-6 py-3">Job Title</th>
                  <th className="px-6 py-3">Department</th>
                  <th className="px-6 py-3">Type</th>
                  <th className="px-6 py-3">Deadline</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-gray-100">
                {dummyJobs.map((j) => (
                  <tr key={j.id} className="hover:bg-gray-50">
                    <td className="px-6 py-4 font-medium text-gray-900">{j.title}</td>
                    <td className="px-6 py-4 text-gray-500">{j.department}</td>
                    <td className="px-6 py-4">
                      <span className={`badge ${j.type === 'government' ? 'badge-blue' : 'badge-green'}`}>
                        {j.type}
                      </span>
                    </td>
                    <td className="px-6 py-4 text-gray-500">{formatDate(j.deadline)}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      )}

      {/* Training Table */}
      {tab === 'trainings' && (
        <div className="glass-card overflow-hidden">
          <div className="overflow-x-auto">
            <table className="w-full text-sm">
              <thead>
                <tr className="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                  <th className="px-6 py-3">Program</th>
                  <th className="px-6 py-3">Provider</th>
                  <th className="px-6 py-3">Category</th>
                  <th className="px-6 py-3">Seats</th>
                  <th className="px-6 py-3">Fee</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-gray-100">
                {dummyTrainings.map((t) => (
                  <tr key={t.id} className="hover:bg-gray-50">
                    <td className="px-6 py-4 font-medium text-gray-900">{t.title}</td>
                    <td className="px-6 py-4 text-gray-500">{t.provider}</td>
                    <td className="px-6 py-4"><span className="badge badge-green">{t.category}</span></td>
                    <td className="px-6 py-4 text-gray-500">{t.enrolled}/{t.seats}</td>
                    <td className="px-6 py-4 font-medium text-primary-700">{t.fee}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      )}
    </div>
  )
}
