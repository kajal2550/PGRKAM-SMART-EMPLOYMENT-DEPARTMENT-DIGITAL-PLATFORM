import { colorClasses } from '../utils/helpers'

/**
 * DashboardCard – stat/metric card for dashboards.
 * Props:
 *   title   {string}
 *   value   {string|number}
 *   icon    {ReactElement}
 *   color   {string}
 *   change  {string} – e.g. "+12%"
 *   trend   {string} – 'up' | 'down'
 *   onClick {Function}
 */
export default function DashboardCard({ title, value, icon, color = 'blue', change, trend, onClick }) {
  const cls = colorClasses(color)

  return (
    <div
      onClick={onClick}
      className={`stat-card ${onClick ? 'cursor-pointer' : ''} animate-slide-up`}
    >
      <div className="flex items-start justify-between mb-4">
        <div className={`w-12 h-12 rounded-2xl ${cls.bg} flex items-center justify-center`}>
          <span className={cls.text}>{icon}</span>
        </div>
        {change && (
          <span
            className={`badge ${
              trend === 'up' ? 'badge-green' : 'badge-red'
            }`}
          >
            {trend === 'up' ? '▲' : '▼'} {change}
          </span>
        )}
      </div>

      <p className="text-2xl font-extrabold text-gray-800 mb-1">
        {typeof value === 'number' ? value.toLocaleString() : value}
      </p>
      <p className="text-sm text-gray-500">{title}</p>
    </div>
  )
}
