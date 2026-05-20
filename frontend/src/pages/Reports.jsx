import { FiTrendingUp, FiUsers, FiBriefcase, FiBookOpen, FiDownload } from 'react-icons/fi'
import DashboardCard from '../components/DashboardCard'

const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
const jobsData    = [420, 580, 490, 700, 820, 940]
const usersData   = [1200, 1450, 1680, 1920, 2300, 2800]

function SimpleBar({ values, color }) {
  const max = Math.max(...values)
  return (
    <div className="flex items-end gap-2 h-32">
      {values.map((v, i) => (
        <div key={i} className="flex-1 flex flex-col items-center gap-1">
          <div
            className={`w-full rounded-t-md ${color} transition-all duration-500`}
            style={{ height: `${(v / max) * 100}%` }}
          />
          <span className="text-xs text-gray-400">{months[i]}</span>
        </div>
      ))}
    </div>
  )
}

export default function Reports() {
  return (
    <div className="space-y-8 animate-fade-in">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-2xl font-extrabold text-gray-900">Reports & Analytics</h1>
          <p className="text-gray-500 text-sm mt-1">Overview of portal activity – 2026</p>
        </div>
        <button className="btn-secondary text-sm flex items-center gap-2">
          <FiDownload size={14} /> Export Report
        </button>
      </div>

      {/* KPI cards */}
      <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
        {[
          { title: 'Total Registrations', value: 3452,  icon: <FiUsers       size={22} />, color: 'blue',   change: '+18%', trend: 'up' },
          { title: 'Jobs Applied',        value: 12640, icon: <FiBriefcase   size={22} />, color: 'green',  change: '+24%', trend: 'up' },
          { title: 'Training Enrolments', value: 2180,  icon: <FiBookOpen    size={22} />, color: 'orange', change: '+11%', trend: 'up' },
          { title: 'Placements',          value: 890,   icon: <FiTrendingUp  size={22} />, color: 'purple', change: '+9%',  trend: 'up' },
        ].map((s) => <DashboardCard key={s.title} {...s} />)}
      </div>

      {/* Charts row */}
      <div className="grid lg:grid-cols-2 gap-6">
        <div className="glass-card p-6">
          <h3 className="font-bold text-gray-900 mb-1">Job Listings (Jan–Jun 2026)</h3>
          <p className="text-xs text-gray-400 mb-4">Monthly new job postings</p>
          <SimpleBar values={jobsData} color="bg-primary-500" />
        </div>
        <div className="glass-card p-6">
          <h3 className="font-bold text-gray-900 mb-1">New Registrations (Jan–Jun 2026)</h3>
          <p className="text-xs text-gray-400 mb-4">Cumulative user sign-ups</p>
          <SimpleBar values={usersData} color="bg-green-500" />
        </div>
      </div>

      {/* District-wise placement table */}
      <div className="glass-card p-6">
        <h3 className="font-bold text-gray-900 mb-5">District-wise Placement Summary</h3>
        <div className="overflow-x-auto">
          <table className="w-full text-sm">
            <thead>
              <tr className="text-left text-xs font-semibold text-gray-500 uppercase border-b border-gray-100">
                <th className="pb-3">District</th>
                <th className="pb-3">Registrations</th>
                <th className="pb-3">Placements</th>
                <th className="pb-3">Success Rate</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-gray-50">
              {[
                { district: 'Chandigarh', reg: 820,  placed: 310, rate: 37.8 },
                { district: 'Ludhiana',   reg: 640,  placed: 230, rate: 35.9 },
                { district: 'Amritsar',   reg: 510,  placed: 180, rate: 35.3 },
                { district: 'Mohali',     reg: 480,  placed: 195, rate: 40.6 },
                { district: 'Patiala',    reg: 370,  placed: 120, rate: 32.4 },
                { district: 'Jalandhar',  reg: 420,  placed: 142, rate: 33.8 },
              ].map((r) => (
                <tr key={r.district} className="hover:bg-gray-50">
                  <td className="py-3 font-medium text-gray-900">{r.district}</td>
                  <td className="py-3 text-gray-600">{r.reg.toLocaleString()}</td>
                  <td className="py-3 text-gray-600">{r.placed.toLocaleString()}</td>
                  <td className="py-3">
                    <div className="flex items-center gap-2">
                      <div className="flex-1 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                        <div className="h-full bg-primary-500 rounded-full" style={{ width: `${r.rate}%` }} />
                      </div>
                      <span className="text-xs font-medium text-gray-700 w-10">{r.rate}%</span>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  )
}
