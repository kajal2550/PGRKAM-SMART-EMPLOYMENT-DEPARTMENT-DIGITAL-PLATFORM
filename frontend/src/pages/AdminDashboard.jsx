import DashboardCard from '../components/DashboardCard'
import { FiUsers, FiBriefcase, FiBookOpen, FiMessageSquare, FiPlus, FiTrash2, FiEye } from 'react-icons/fi'
import { dummyJobs, dummyTrainings, formatDate } from '../utils/helpers'
import { useState } from 'react'
import toast from 'react-hot-toast'

const mockUsers = [
  { id: 1, name: 'Harpreet Singh',  email: 'h.singh@email.com',    role: 'user',  status: 'active',   joined: '2026-01-15' },
  { id: 2, name: 'Gurpreet Kaur',   email: 'g.kaur@email.com',     role: 'user',  status: 'active',   joined: '2026-02-20' },
  { id: 3, name: 'Amandeep Sharma', email: 'a.sharma@email.com',   role: 'user',  status: 'inactive', joined: '2026-03-10' },
  { id: 4, name: 'Rajinder Singh',  email: 'r.singh@email.com',    role: 'admin', status: 'active',   joined: '2025-12-01' },
]

const adminStats = [
  { title: 'Total Users',        value: 3452,  icon: <FiUsers       size={22} />, color: 'blue',   change: '+12%', trend: 'up'   },
  { title: 'Active Jobs',        value: 186,   icon: <FiBriefcase   size={22} />, color: 'green',  change: '+8%',  trend: 'up'   },
  { title: 'Training Programs',  value: 48,    icon: <FiBookOpen    size={22} />, color: 'orange', change: '+3',   trend: 'up'   },
  { title: 'Counselling Reqs',   value: 94,    icon: <FiMessageSquare size={22}/>, color: 'purple', change: '+21%', trend: 'up'  },
]

export default function AdminDashboard() {
  const [users, setUsers] = useState(mockUsers)
  const [tab, setTab] = useState('users')

  const deleteUser = (id) => {
    setUsers(users.filter((u) => u.id !== id))
    toast.success('User removed')
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
