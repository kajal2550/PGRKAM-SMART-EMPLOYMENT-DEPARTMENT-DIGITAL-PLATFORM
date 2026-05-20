/**
 * Loader – full-page or inline spinner.
 * Props:
 *   fullPage {boolean} – centre on viewport
 *   size     {string}  – 'sm' | 'md' | 'lg'
 *   text     {string}  – optional label
 */
export default function Loader({ fullPage = false, size = 'md', text = 'Loading…' }) {
  const sizeMap = {
    sm: 'w-5 h-5 border-2',
    md: 'w-10 h-10 border-4',
    lg: 'w-16 h-16 border-4',
  }

  const spinner = (
    <div className="flex flex-col items-center justify-center gap-3">
      <div
        className={`${sizeMap[size]} rounded-full border-primary-200 border-t-primary-600 animate-spin`}
      />
      {text && <p className="text-sm text-gray-500 animate-pulse">{text}</p>}
    </div>
  )

  if (fullPage) {
    return (
      <div className="fixed inset-0 z-50 flex items-center justify-center bg-white/80 backdrop-blur-sm">
        {spinner}
      </div>
    )
  }

  return (
    <div className="flex items-center justify-center py-12">
      {spinner}
    </div>
  )
}
