import { LayoutDashboard, Package, TrendingUp, ShoppingCart, Settings, Zap, ChevronLeft, ChevronRight } from 'lucide-react';
import { useState } from 'react';
import logo from '../assets/logo.png';

const menuItems = [
  { id: 'dashboard', label: 'AI Dashboard', icon: LayoutDashboard },
  { id: 'inventory', label: 'Master Inventory', icon: Package },
  { id: 'forecasting', label: 'Demand Forecasting', icon: TrendingUp },
  { id: 'purchase_orders', label: 'Purchase Orders', icon: ShoppingCart },
  { id: 'settings', label: 'AI Engine Settings', icon: Settings },
];

export default function Sidebar({ activeTab, setActiveTab, isSidebarOpen, toggleSidebar }) {
  const [hardwareAcceleration, setHardwareAcceleration] = useState(true);

  return (
    <aside 
      className={`bg-[#0a0c10] border-r border-[var(--border)] flex flex-col h-screen sticky top-0 transition-all duration-300 ease-in-out ${
        isSidebarOpen ? 'w-64' : 'w-20'
      }`}
    >
      {/* Logo Area */}
      <div className={`h-20 flex items-center border-b border-[var(--border)] ${isSidebarOpen ? 'px-6 justify-between' : 'px-0 justify-center'}`}>
        <div className={`flex items-center gap-3 overflow-hidden transition-all duration-300 ${isSidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0 hidden'}`}>
          <img src={logo} alt="NexStock AI Logo" className="w-8 h-8 object-contain" />
          <span className="text-xl font-bold tracking-tight text-white whitespace-nowrap">NexStock <span className="text-indigo-400">AI</span></span>
        </div>
        
        {/* If collapsed, show logo centered */}
        {!isSidebarOpen && (
          <img src={logo} alt="Logo" className="w-8 h-8 object-contain" />
        )}
      </div>

      {/* Navigation */}
      <nav className="flex-1 px-3 py-6 space-y-2 overflow-y-auto overflow-x-hidden">
        {menuItems.map((item) => {
          const Icon = item.icon;
          const isActive = activeTab === item.id;
          return (
            <button
              key={item.id}
              onClick={() => setActiveTab(item.id)}
              className={`w-full flex items-center rounded-lg font-medium transition-all duration-200 group relative ${
                isSidebarOpen ? 'px-3 py-2.5 gap-3' : 'justify-center p-3'
              } ${
                isActive 
                  ? 'bg-indigo-500/10 text-indigo-400' 
                  : 'text-gray-400 hover:text-gray-200 hover:bg-gray-800/50'
              }`}
              title={!isSidebarOpen ? item.label : undefined}
            >
              <Icon className="w-5 h-5 shrink-0" />
              
              <span className={`whitespace-nowrap transition-all duration-300 ${
                isSidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0 hidden'
              }`}>
                {item.label}
              </span>

              {/* Tooltip for collapsed state */}
              {!isSidebarOpen && (
                <div className="absolute left-full ml-4 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all whitespace-nowrap z-50">
                  {item.label}
                </div>
              )}
            </button>
          );
        })}
      </nav>

      {/* Hardware Toggle & Sidebar Toggle */}
      <div className="border-t border-[var(--border)] p-4 flex flex-col gap-4">
        
        {/* Hardware Toggle Container */}
        <div className={`bg-[#161b22] rounded-xl border border-[var(--border)] transition-all duration-300 overflow-hidden ${
          isSidebarOpen ? 'p-4' : 'p-2 flex justify-center'
        }`}>
          {isSidebarOpen ? (
            <>
              <div className="flex items-center justify-between mb-2">
                <span className="text-sm font-medium text-gray-300 whitespace-nowrap">NVIDIA cuDF</span>
                <button 
                  onClick={() => setHardwareAcceleration(!hardwareAcceleration)}
                  className={`relative inline-flex h-5 w-9 shrink-0 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900 ${
                    hardwareAcceleration ? 'bg-indigo-500' : 'bg-gray-600'
                  }`}
                >
                  <span className={`inline-block h-3.5 w-3.5 transform rounded-full bg-white transition-transform ${
                    hardwareAcceleration ? 'translate-x-4' : 'translate-x-1'
                  }`} />
                </button>
              </div>
              <p className="text-xs text-gray-500 leading-relaxed whitespace-nowrap">
                Hardware acceleration is <strong className={hardwareAcceleration ? 'text-indigo-400' : 'text-gray-400'}>{hardwareAcceleration ? 'ON' : 'OFF'}</strong>
              </p>
            </>
          ) : (
            <button 
              onClick={() => setHardwareAcceleration(!hardwareAcceleration)}
              title={hardwareAcceleration ? "Hardware Accel: ON" : "Hardware Accel: OFF"}
              className={`w-8 h-8 rounded-lg flex items-center justify-center transition-colors ${
                hardwareAcceleration ? 'bg-indigo-500/20 text-indigo-400' : 'bg-gray-800 text-gray-500'
              }`}
            >
              <Zap className="w-4 h-4" />
            </button>
          )}
        </div>

        {/* Sidebar Toggle Button */}
        <button 
          onClick={toggleSidebar}
          className="w-full flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-white hover:bg-gray-800/50 transition-colors"
        >
          {isSidebarOpen ? (
            <div className="flex items-center gap-2 w-full justify-end px-2">
              <span className="text-sm text-gray-500">Collapse</span>
              <ChevronLeft className="w-5 h-5" />
            </div>
          ) : (
            <ChevronRight className="w-5 h-5" />
          )}
        </button>
      </div>
    </aside>
  );
}
